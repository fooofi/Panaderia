<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Institution;
use App\Models\InstitutionBanner;
use App\Models\InstitutionDependency;
use App\Models\InstitutionIcon;
use App\Models\InstitutionType;
use App\Models\Organization;
use App\Models\User;
use App\Rules\Rut;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

class InstitutionController extends Controller
{
    //
    public function index()
    {
        $admin = auth()
            ->user()
            ->hasRole('admin');

        if ($admin) {
            return $this->adminIndex();
        }
        $institutions = auth()
            ->user()
            ->organization->institutions->map(function ($institution) {
                $users = $institution->organization->users
                    ->filter(function ($user) use ($institution) {
                        return $user->can('institutions.view.' . $institution->id) &&
                            $user->cant('institutions.edit.' . $institution->id);
                    })
                    ->count();
                return (object) [
                    'id' => $institution->id,
                    'name' => $institution->name,
                    'type' => $institution->institution_type->name,
                    'dependency' => $institution->institution_dependency->name,
                    'cruch' => $institution->cruch,
                    'sua' => $institution->sua,
                    'gratuidad' => $institution->gratuidad,
                    'users' => $users,
                    'max_users' => $institution->max_users,
                ];
            });
        return view('institutions.index', [
            'institutions' => $institutions,
            'admin' => false,
        ]);
    }

    public function create()
    {
        $user = auth()->user();
        $dependencies = InstitutionDependency::all()->map(function ($dependency) {
            return (object) [
                'id' => $dependency->id,
                'name' => $dependency->name,
            ];
        });

        $types = InstitutionType::all()->map(function ($type) {
            return (object) [
                'id' => $type->id,
                'name' => $type->name,
            ];
        });
        $organizations = Organization::all()->map(function ($organization) {
            return (object) [
                'id' => $organization->id,
                'name' => $organization->fantasy_name,
            ];
        });
        return view('institutions.create', [
            'organizations' => $organizations,
            'dependencies' => $dependencies,
            'types' => $types,
            'organization_id' => $user->organization_id,
            'admin' => $user->hasRole('admin'),
        ]);
    }

    public function show($id)
    {
        $institution = Institution::find($id);
        $logo = $institution->file;
        $banner = $institution->institution_banner;
        $icon = $institution->institution_icon;
        $institution = (object) [
            'id' => $institution->id,
            'name' => $institution->name,
            'link' => $institution->link,
            'phone' => $institution->phone,
            'cruch' => $institution->cruch,
            'sua' => $institution->sua,
            'gratuidad' => $institution->gratuidad,
            'type' => $institution->institution_type->name,
            'dependency' => $institution->institution_dependency->name,
            'logo' => $logo ? $logo->id : 0,
            'banner' => $banner ? $banner->file->id : 0,
            'icon' => $icon ? $icon->file->id : 0,
            'editPermission' => 'institutions.edit.' . $institution->id,
        ];
        $dependencies = InstitutionDependency::all()->map(function ($dependency) {
            return (object) [
                'id' => $dependency->id,
                'name' => $dependency->name,
            ];
        });

        $types = InstitutionType::all()->map(function ($type) {
            return (object) [
                'id' => $type->id,
                'name' => $type->name,
            ];
        });
        return view('institutions.show', [
            'institution' => $institution,
            'dependencies' => $dependencies,
            'types' => $types,
        ]);
    }

    public function edit(Request $request)
    {
        $this->validatorEdit($request->all())->validate();
        $institution = $this->update($request->all());
        return redirect()->route('institutions.show', $institution->id);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if (!$user->hasPermissionTo('institutions')) {
            return redirect()->route('dashboard');
        }
        $this->validator($request->all())->validate();
        if ($request->organization != $user->organization_id && $user->hasRole('manager')) {
            return redirect()->route('dashboard');
        }
        event(new Registered($this->createInstitution($request->all())));
        return redirect()->route('institutions');
    }

    public function delete(Request $request)
    {
        return redirect()->route('manager.institutions');
    }

    public function deleteLogo(Request $request)
    {
        $this->validatorImage($request->all(), 'logo', false)->validate();
        $institution = Institution::find($request->institution);
        if ($institution->file) {
            Storage::disk($institution->file->disk)->delete($institution->file->path);
            $institution->file->delete();
        }
        return redirect()->route('institutions.show', $institution->id);
    }

    public function deleteBanner(Request $request)
    {
        $this->validatorImage($request->all(), 'banner', false)->validate();
        $institution = Institution::find($request->institution);
        $banner = $institution->institution_banner;
        if ($banner) {
            Storage::disk($banner->file->disk)->delete($banner->file->path);
            $banner->file->delete();
            $banner->delete();
        }
        return redirect()->route('institutions.show', $institution->id);
    }

    public function deleteIcon(Request $request)
    {
        $this->validatorImage($request->all(), 'icon', false)->validate();
        $institution = Institution::find($request->institution);
        $icon = $institution->institution_icon;
        if ($icon) {
            Storage::disk($icon->file->disk)->delete($icon->file->path);
            $icon->file->delete();
            $icon->delete();
        }
        return redirect()->route('institutions.show', $institution->id);
    }

    public function createLogo(Request $request)
    {
        $this->validatorImage($request->all(), 'logo', true)->validate();
        $institution = Institution::find($request->institution);

        if (!$institution->file) {
            File::create([
                'path' => $request->logo->store('files'),
                'fileable_id' => $request->institution,
                'fileable_type' => 'App\Models\Institution',
            ]);
        }

        return redirect()->route('institutions.show', $request->institution);
    }

    public function createBanner(Request $request)
    {
        $this->validatorImage($request->all(), 'banner', true)->validate();
        $institution = Institution::find($request->institution);
        if (!$institution->institution_banner) {
            $banner = InstitutionBanner::create(['institution_id' => $request->institution]);
            File::create([
                'path' => $request->banner->store('files'),
                'fileable_id' => $banner->id,
                'fileable_type' => 'App\Models\InstitutionBanner',
            ]);
        }

        return redirect()->route('institutions.show', $request->institution);
    }

    public function createIcon(Request $request)
    {
        $this->validatorImage($request->all(), 'icon', true)->validate();
        $institution = Institution::find($request->institution);
        if (!$institution->institution_icon) {
            $icon = InstitutionIcon::create(['institution_id' => $request->institution]);
            File::create([
                'path' => $request->icon->store('files'),
                'fileable_id' => $icon->id,
                'fileable_type' => 'App\Models\InstitutionIcon',
            ]);
        }

        return redirect()->route('institutions.show', $request->institution);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'organization' => ['required', 'integer', 'exists:organizations,id'],
            'dependency' => ['required', 'integer', 'exists:institution_dependencies,id'],
            'type' => ['required', 'integer', 'exists:institution_types,id'],
            'cruch' => ['string', 'in:on'],
            'sua' => ['string', 'in:on'],
            'gratuidad' => ['string', 'in:on'],
            'link' => ['required', 'string', 'url', 'max:255'],
            'phone' => ['required', 'string', 'max:9', 'min:9'],
            'user_name' => ['required', 'string', 'max:255'],
            'user_lastname' => ['required', 'string', 'max:255'],
            'user_rut' => ['required', 'string', new Rut()],
            'user_email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'user_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function validatorEdit(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:9', 'min:9'],
            'dependency' => ['required', 'integer', 'exists:institution_dependencies,id'],
            'type' => ['required', 'integer', 'exists:institution_types,id'],
            'link' => ['required', 'string', 'url', 'max:255'],
            'cruch' => ['string', 'in:on'],
            'sua' => ['string', 'in:on'],
            'gratuidad' => ['string', 'in:on'],
        ]);
    }

    protected function validatorImage(array $data, $image_name, $create)
    {
        $max_upload_size = config('app.max_image_filesize');

        if ($create) {
            return Validator::make($data, [
                $image_name => ['required', 'file', "max:$max_upload_size", 'image', 'mimes:jpeg,jpg,jpe,png,svg'],
            ]);
        } else {
            return Validator::make($data, [
                'image' => ['required', 'integer', 'exists:files,id'],
            ]);
        }
    }
    protected function createInstitution(array $data)
    {
        $institution = Institution::create([
            'name' => $data['name'],
            'link' => $data['link'],
            'phone' => '+56' . $data['phone'],
            'institution_dependency_id' => $data['dependency'],
            'institution_type_id' => $data['type'],
            'cruch' => Arr::exists($data, 'cruch'),
            'sua' => Arr::exists($data, 'sua'),
            'gratuidad' => Arr::exists($data, 'gratuidad'),
            'organization_id' => $data['organization'],
        ]);
        Permission::create(['name' => 'institutions.view.' . $institution->id]);
        Permission::create(['name' => 'institutions.edit.' . $institution->id]);
        return User::create([
            'name' => $data['user_name'],
            'lastname' => $data['user_lastname'],
            'rut' => $data['user_rut'],
            'email' => $data['user_email'],
            'password' => Hash::make($data['user_password']),
            'organization_id' => $data['organization'],
        ])
            ->assignRole('manager')
            ->givePermissionTo([
                'institutions.view.' . $institution->id,
                'institutions.edit.' . $institution->id,
                'campuses',
                'careers',
            ]);
    }

    protected function update(array $data)
    {
        $institution = Institution::find($data['institution']);

        if ($institution->name != $data['name']) {
            $institution->name = $data['name'];
        }
        if ($institution->link != $data['link']) {
            $institution->link = $data['link'];
        }
        if ($institution->phone != $data['phone']) {
            $institution->phone = '+56' . $data['phone'];
        }
        if ($institution->cruch != Arr::exists($data, 'cruch')) {
            $institution->cruch = Arr::exists($data, 'cruch');
        }
        if ($institution->sua != Arr::exists($data, 'sua')) {
            $institution->sua = Arr::exists($data, 'sua');
        }
        if ($institution->gratuidad != Arr::exists($data, 'gratuidad')) {
            $institution->gratuidad = Arr::exists($data, 'gratuidad');
        }
        if ($institution->institution_type_id != $data['type']) {
            $institution->institution_type_id = $data['type'];
        }
        if ($institution->institution_dependency_id != $data['dependency']) {
            $institution->institution_dependency_id = $data['dependency'];
        }

        $institution->save();
        return $institution;
    }

    protected function adminIndex()
    {
        $organizations = Organization::all();
        $institutions = $organizations
            ->map(function ($organization) {
                return $organization->institutions->map(function ($institution) {
                    $users = $institution->organization->users
                        ->filter(function ($user) use ($institution) {
                            return $user->can('institutions.view.' . $institution->id) &&
                                $user->cant('institutions.edit.' . $institution->id);
                        })
                        ->count();
                    return (object) [
                        'id' => $institution->id,
                        'organization' => $institution->organization->fantasy_name,
                        'name' => $institution->name,
                        'type' => $institution->institution_type->name,
                        'dependency' => $institution->institution_dependency->name,
                        'cruch' => $institution->cruch,
                        'sua' => $institution->sua,
                        'gratuidad' => $institution->gratuidad,
                        'users' => $users,
                        'max_users' => $institution->max_users,
                    ];
                });
            })
            ->flatten()
            ->paginate();
        return view('institutions.index', ['institutions' => $institutions, 'admin' => true]);
    }
}
