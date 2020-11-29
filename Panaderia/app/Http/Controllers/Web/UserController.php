<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Institution;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use App\Rules\Rut;
use Spatie\Permission\Contracts\Permission;


class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show a user list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // TODO: admin debe ver todo por
        // institution user no tiene institutionId => puede editar la organizacion
        // manager tiene institution id => editar una sola instituciuon

        $user = auth()->user();
        if ($user->hasRole('admin')) {
            return $this->adminIndex($request);
        } else {
            return $this->managerIndex();
        }

        $users = User::paginate();
        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    public function adminIndex(Request $request)
    {
        $organizations = Organization::all();
        $organization_id = $request->organization;
        $users = $organizations
            ->map(function ($organization) {
                $users = $organization->users->map(function ($user) {
                    
                    return (object) [
                        'id'              => $user->id,
                        'name'            => $user->name,
                        'lastname'        => $user->lastname,
                        'email'           => $user->email,
                        'rut'             => $user->rut,
                        'role'            => $user->roles->first() ? $user->roles->first()->name: 'sin rol',
                        'organization_id' => $user->organization_id
                        
                    ];
                    
                    
                });
                return (object) [
                        'id'           => $organization->id,
                        'fantasy_name' => $organization->fantasy_name,
                        'users'        => $users,
                ];
            })
            ->flatten()->paginate();


        if ($organization_id) {
            $users = $users->filter(function ($organization) use ($organization_id) {
                return $organization->id == $organization_id;
            })->paginate();
        }
        $organizations = $organizations->map(function ($organization) {
            return (object) [
                'id' => $organization->id,
                'name' => $organization->fantasy_name,
            ];
        });
        return view('admin.users.index', [
            'users'           => $users,
            'organizations'   => $organizations,
            'organization_id' => $organization_id,
            'admin'           => true,
        ]);
    }

    public function create(Request $data)
    {
        $institutions = Organization::find($data->organization)->institutions->map(function ($institution) {
            return (object) [
                'name' => $institution->name,
                'id' => $institution->id,
            ];
        });
        return view('admin.users.create',[
            'organization_id' => $data->organization,
            'institutions'    => $institutions,
            ]);
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $this->createUser($request->all());
        return redirect()->route('users');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'            => ['required', 'string', 'max:255'],
            'lastname'        => ['required', 'string', 'max:255'],
            'email'           => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'rut'             => ['required', 'string', new Rut()],
            'user_type'       => ['required', 'integer', 'max:255'],
            'user_password'   => ['required', 'string', 'min:8', 'confirmed'],
            'organization_id' => ['required', 'integer', 'exists:organizations,id'],
        ]);
    }

    public function createUser(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'rut' => $data['rut'],
            'password' => Hash::make($data['user_password']),
            'organization_id' => $data['organization_id'],
        ]);

        if ($data['user_type'] == 1) 
        {
            $user->assignRole('executive')
                ->givePermissionTo(['institutions.view.'. $data['institution_id'] ]);
        }elseif($data['user_type'] == 2){

            if (Institution::find($data['institution_id'])) 
            {
                $view = 'institutions.view.' . $data['institution_id'];
                $edit = 'institutions.edit.' . $data['institution_id'];

                $user->assignRole('manager')
                    ->givePermissionTo([$view, $edit, 'campuses', 'careers']);

            }else{
                $user->assignRole('manager')
                    ->givePermissionTo('institutions', 'campuses', 'careers');
            }
            
        }


        return $user;
    }

    /**
     * Get User Change Passwrod View
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function changePassword(Request $request)
    {
        if ($request->isMethod('post')) {

            $validator = $this->passwordValidator($request->all())->validate();
            $user = auth()->user();

            if (!Hash::check($request['old_password'], $user->password)) {
                $errors = new MessageBag();
                $errors->add('wrong_password', 'Contraseña incorrecta');
                return view('admin.users.password')->withErrors($errors);
            }
            if (Hash::check($request['new_password'], $user->password)) {
                $errors = new MessageBag();
                $errors->add('wrong_new_password', 'La contraseña nueva es igual a la anterior.');
                return view('admin.users.password')->withErrors($errors);
            }

            $user->password = Hash::make($request['new_password']);
            $user->save();

            return view('admin.users.password',[
                'successfull' => true
            ]);
        }

        return view('admin.users.password');
    }

    protected function passwordValidator(array $data)
    {
        return Validator::make($data, [
            'old_password' => ['required', 'string', 'min:8'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function show($id)
    {
        $user = User::find($id);
        $institutions = $user->organization->institutions->map(function ($institution) {
            return (object) [
                'name' => $institution->name,
                'id' => $institution->id,
            ];
        });

        return view('admin.users.show', [
            'user'   => $user,
            'admin'  => true,
            'institutions'    => $institutions,
        ]);
    }

    public function edit(Request $request)
    {
        $this->validatorEdit($request->all())->validate();
        $user = $this->update($request->all());
        return redirect()->route('users.show', $user->id);
    }

    protected function validatorEdit(array $data)
    {
        return Validator::make($data, [
            'name'            => ['required', 'string', 'max:255'],
            'lastname'        => ['required', 'string', 'max:255'],
            'rut'             => ['required', 'string', new Rut()],
            'user_type'       => ['required', 'integer'],
        ]);
    }

    protected function update(array $data)
    {
        $user = User::find($data['id']);

        if ($user->name != $data['name']) {
            $user->name = $data['name'];
        }
        if ($user->lastname != $data['lastname']) {
            $user->lastname = $data['lastname'];
        }
        if ($user->rut != $data['rut']) {
            $user->rut = $data['rut'];
        }
        
            $user->removeRole($user->roles->first()->name);

        if ($data['user_type'] == 1) 
        {
            if (Institution::find($data['institution_id'])) 
            {
                $user->assignRole('executive')
                ->givePermissionTo(['institutions.view.'. $data['institution_id'] ]);
            }else{
                $user->assignRole('executive')
                    ->givePermissionTo(['institutions']);
            }
        }elseif($data['user_type'] == 2){

            if (Institution::find($data['institution_id'])) 
            {
                $view = 'institutions.view.' . $data['institution_id'];
                $edit = 'institutions.edit.' . $data['institution_id'];

                $user->assignRole('manager')
                    ->givePermissionTo([$view, $edit, 'campuses', 'careers']);

            }else{
                $user->assignRole('manager')
                    ->givePermissionTo('institutions', 'campuses', 'careers');
            }

        }

        if ( isset($data['user_password']) && $data['user_password'] != null && $data['user_password'] != '') {
            $user->user_password = Hash::make($data['user_password']) ;
        }

        $user->save();
        return $user;
    }

    public function delete(Request $request)
    {
        $user = User::find($request->id);
        $user->delete();

        if ($user->trashed()) 
        {
            return redirect()->route('users');
        }
        
    }
}
