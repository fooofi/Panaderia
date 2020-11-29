<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Organization;
use App\Models\OrganizationType;
use App\Models\User;
use App\Rules\Rut;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class OrganizationController extends Controller
{
    //
    public function index()
    {
        $organizations = Organization::paginate();
        return view('admin.organizations.index', [
            'organizations' => $organizations,
        ]);
    }

    public function create()
    {
        $types = OrganizationType::all()->map(function ($type) {
            return (object) [
                'id' => $type->id,
                'name' => $type->name,
            ];
        });
        $countries = Country::all()->map(function ($country) {
            return (object) [
                'id' => $country->id,
                'name' => $country->name,
            ];
        });
        return view('admin.organizations.create', [
            'types' => $types,
            'countries' => $countries,
        ]);
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($this->createOrganization($request->all())));
        return redirect()->route('admin.organizations');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'business_name' => ['required', 'string', 'max:255'],
            'fantasy_name' => ['required', 'string', 'max:255'],
            'rut' => ['required', 'string', new Rut()],
            'type' => ['required', 'integer', 'exists:organization_types,id'],
            'commune' => ['required', 'integer', 'exists:communes,id'],
            'address' => ['required', 'string', 'max:255'],
            'user_name' => ['required', 'string', 'max:255'],
            'user_lastname' => ['required', 'string', 'max:255'],
            'user_email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'user_rut' => ['required', 'string', new Rut()],
            'user_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function createOrganization(array $data)
    {
        $org = Organization::create([
            'business_name' => $data['business_name'],
            'fantasy_name' => $data['fantasy_name'],
            'rut' => $data['rut'],
            'organization_type_id' => $data['type'],
            'commune_id' => $data['commune'],
            'address' => $data['address'],
        ]);

        return User::create([
            'name' => $data['user_name'],
            'lastname' => $data['user_lastname'],
            'email' => $data['user_email'],
            'rut' => $data['user_rut'],
            'password' => Hash::make($data['user_password']),
            'organization_id' => $org->id,
        ])
            ->assignRole('manager')
            ->givePermissionTo('institutions', 'campuses', 'careers');
    }
}
