<?php

namespace Database\Seeders;

use App\Models\Campus;
use App\Models\CampusCareer;
use App\Models\Career;
use App\Models\CarrerScore;
use App\Models\CareerScholarship;
use App\Models\FairSurvey;
use App\Models\FairUser;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Organization;
use App\Models\OrganizationType;
use App\Models\Institution;
use App\Models\InstitutionDependency;
use App\Models\InstitutionType;
use App\Models\Scholarship;
use Database\Factories\OrganizationFactory;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Faker\Factory;
use Illuminate\Support\Facades\Log;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'lastname' => 'Test',
            'rut' => '11111111-1',
            'email' => 'admin@test.com',
            'password' => Hash::make('1234567890'),
        ])
            ->assignRole('admin');
    
    }
}
