<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\CampusImage;
use App\Models\Commune;
use App\Models\Country;
use App\Models\File;
use App\Models\Institution;
use App\Models\Organization;
use App\Models\Province;
use App\Models\Region;
use App\Rules\Geocode;
use Facade\FlareClient\Http\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CampusController extends Controller
{
    //
    public function index(Request $request)
    {
        $user = auth()->user();
        if ($user->hasRole('admin')) {
            return $this->adminIndex($request);
        } else {
            return $this->managerIndex($request);
        }
    }

    public function create(Request $request)
    {
        $countries = Country::all()->map(function ($country) {
            return (object) [
                'id' => $country->id,
                'name' => $country->name,
            ];
        });
        return view('campuses.create', [
            'institution_id' => $request->institution,
            'countries' => $countries,
            'admin' => auth()
                ->user()
                ->hasRole('admin'),
        ]);
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $this->createCampus($request->all());
        return redirect()->route('campuses');
    }

    public function show($id)
    {
        $campus = Campus::find($id);
        $user = auth()->user();
        $images = $campus->campus_images->map(function ($image) {
            return (object) [
                'id' => $image->file->id,
            ];
        });
        $campus = (object) [
            'id' => $campus->id,
            'name' => $campus->name,
            'description' => $campus->description,
            'address' => $campus->address,
            'fullAddress' => $campus->address . ', ' . $campus->commune->collapseName(false),
            'link' => $campus->link,
            'phone' => $campus->phone,
            'institution' => $campus->institution_id,
            'editPermission' => 'institutions.edit.' . $campus->institution_id,
            'location_lat' => $campus->location_lat,
            'location_lon' => $campus->location_lon,
            'maxImages' => $campus->max_images,
            'images' => $images,
            'commune_id' => $campus->commune_id,
            'province_id' => $campus->commune->province->id,
            'region_id' => $campus->commune->province->region->id,
            'country_id' => $campus->commune->province->region->country->id,
        ];

        return view('campuses.show', [
            'campus' => $campus,
            'countries' => Country::all(),
            'regions' => Country::find($campus->country_id)->regions,
            'provinces' => Region::find($campus->region_id)->provinces,
            'communes' => Province::find($campus->province_id)->communes,
        ]);
    }

    public function update(Request $request)
    {
        $this->validatorEdit($request->all())->validate();
        $this->updateCampus($request->all());
        return redirect()->route('campuses.show', $request->id);
    }

    public function deleteImages(Request $request)
    {
        $this->validatorImages($request->all(), false);
        $campus = Campus::find($request->id);

        $campus_image = $campus->campus_images
            ->filter(function ($image) use ($request) {
                return $image->file->id == $request->image;
            })
            ->first();
        if ($campus_image) {
            $image = $campus_image->file;
            Storage::disk($image->disk)->delete($image->path);
            $image->delete();
            $campus_image->delete();
        }

        return redirect()->route('campuses.show', $campus->id);
    }

    public function addImages(Request $request)
    {
        $this->validatorImages($request->all(), true)->validate();
        $campus = Campus::find($request->id);

        if ($campus->campus_images->count() < $campus->max_images) {
            $campus_image = CampusImage::create([
                'campus_id' => $campus->id,
            ]);
            File::create([
                'path' => $request->image->store('files'),
                'fileable_id' => $campus_image->id,
                'fileable_type' => 'App\Models\CampusImage',
            ]);
        }

        return redirect()->route('campuses.show', $campus->id);
    }

    protected function validatorImages(array $data, $create)
    {
        $max_upload_size = config('app.max_image_filesize');

        if ($create) {
            return Validator::make($data, [
                'image' => ['required', 'file', "max:$max_upload_size", 'image', 'mimes:jpeg,jpg,jpe,png,svg'],
                'id' => ['required', 'integer', 'exists:campuses,id'],
            ]);
        } else {
            return Validator::make($data, [
                'image' => ['required', 'integer', 'exists:files,id'],
                'id' => ['required', 'integer', 'exists:campuses,id'],
            ]);
        }
    }
    protected function validatorEdit(array $data)
    {
        $user = auth()->user();
        return Validator::make($data, [
            'id' => ['required', 'integer', 'exists:campuses,id'],
            'institution' => [
                'required',
                'integer',
                Rule::exists('institutions', 'id')->where(function ($query) use ($user) {
                    if ($user->hasRole('manager')) {
                        $query->where('organization_id', auth()->user()->organization_id);
                    }
                }),
            ],
            'name' => ['required', 'string', 'max:255'],
            'link' => ['required', 'string', 'url', 'max:255'],
            'phone' => ['required', 'string'],
            'description' => ['required', 'string', 'max:3000'],
            'commune' => ['required', 'integer', 'exists:communes,id'],
            'address' => ['required', 'string', 'max:255', new Geocode($data)],
        ]);
    }

    protected function updateCampus(array $data)
    {
        $campus = Campus::find($data['id']);

        if ($campus->name != $data['name']) {
            $campus->name = $data['name'];
        }
        if ($campus->link != $data['link']) {
            $campus->link = $data['link'];
        }
        if ($campus->phone != $data['phone']) {
            $campus->phone = '+56' . $data['phone'];
        }
        if ($campus->description != $data['description']) {
            $campus->description = $data['description'];
        }
        if ($campus->commune_id != $data['commune'] || $campus->address != $data['address']) {
            $campus->commune_id = $data['commune'];
            $campus->address = $data['address'];
            $response = $this->sendAddress($data['address'], $data['commune']);
            $campus->location_lat = $response['results'][0]['geometry']['location']['lat'];
            $campus->location_lon = $response['results'][0]['geometry']['location']['lng'];
        }
        $campus->save();
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'link' => ['required', 'string', 'url', 'max:255'],
            'commune' => ['required', 'integer', 'exists:communes,id'],
            'address' => ['required', 'string', 'max:255', new Geocode($data)],
            'phone' => ['required', 'string', 'min:9', 'max:9'],
            'description' => ['required', 'string', 'max:3000'],
            'institution' => [
                'required',
                'integer',
                Rule::exists('institutions', 'id')->where(function ($query) {
                    if (
                        auth()
                            ->user()
                            ->hasRole('manager')
                    ) {
                        $query->where('organization_id', auth()->user()->organization_id);
                    }
                }),
            ],
        ]);
    }

    protected function createCampus(array $data)
    {
        $response = $this->sendAddress($data['address'], $data['commune']);
        Campus::create([
            'name' => $data['name'],
            'link' => $data['link'],
            'address' => $data['address'],
            'phone' => '+56' . $data['phone'],
            'description' => $data['description'],
            'commune_id' => $data['commune'],
            'institution_id' => $data['institution'],
            'location_lat' => $response['results'][0]['geometry']['location']['lat'],
            'location_lon' => $response['results'][0]['geometry']['location']['lng'],
        ]);
    }

    protected function adminIndex(Request $request)
    {
        $organizations = Organization::all();

        $organization_id = intval($request->organization);
        $institutions = $organizations
            ->map(function ($organization) {
                return $organization->institutions->map(function ($institution) {
                    $campuses = $institution->campuses->map(function ($campus) {
                        return (object) [
                            'id' => $campus->id,
                            'name' => $campus->name,
                            'description' => $campus->description,
                            'address' => $campus->address,
                            'commune' => $campus->commune->name,
                            'link' => $campus->link,
                        ];
                    });
                    return (object) [
                        'id' => $institution->id,
                        'name' => $institution->name,
                        'campuses' => $campuses,
                        'organization_id' => $institution->organization_id,
                    ];
                });
            })
            ->flatten();
        if ($organization_id) {
            $institutions = $institutions->filter(function ($institution) use ($organization_id) {
                return $institution->organization_id == $organization_id;
            });
        }
        $organizations = $organizations->map(function ($organization) {
            return (object) [
                'id' => $organization->id,
                'name' => $organization->business_name,
            ];
        });
        return view('campuses.index', [
            'institutions' => $institutions,
            'organizations' => $organizations,
            'organization_id' => $organization_id,
        ]);
    }

    protected function managerIndex()
    {
        $organization = auth()->user()->organization;
        $institutions = $organization->institutions->filter(function ($institution) {
            $institution_id = auth()
                ->user()
                ->institutionId();
            if ($institution_id) {
                return $institution->id == $institution_id;
            }
            return true;
        });
        $institutions = $institutions->map(function ($institution) {
            $campuses = $institution->campuses->map(function ($campus) {
                return (object) [
                    'id' => $campus->id,
                    'name' => $campus->name,
                    'description' => $campus->description,
                    'address' => $campus->address,
                    'commune' => $campus->commune->name,
                    'link' => $campus->link,
                ];
            });
            return (object) [
                'id' => $institution->id,
                'name' => $institution->name,
                'campuses' => $campuses,
            ];
        });
        return view('campuses.index', [
            'institutions' => $institutions,
        ]);
    }

    protected function sendAddress($address, $commune_id)
    {
        $commune = Commune::find($commune_id);
        $province = $commune->province;
        $region = $province->region;
        $country = $region->country;
        $response = Http::get(config('app.google_geocode_json_api'), [
            'key' => config('app.google_mix_api_key'),
            'address' => preg_replace('/\s+/', '+', $address),
            'components' =>
                $commune->geocodeComponent() .
                '|' .
                $province->geocodeComponent() .
                '|' .
                $region->geocodeComponent() .
                '|' .
                $country->geocodeComponent(),
        ]);

        return $response->json();
    }
}
