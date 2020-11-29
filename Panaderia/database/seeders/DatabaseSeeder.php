<?php

namespace Database\Seeders;

// use App\Models\Career;
use App\Models\ScholarshipOwner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesSeeder::class,
        ]);
        // Create Search Index for Careers
        // Artisan::call('scout:mysql-index', ['model' => Career::class]);
        // Load production seeder

        $this->call(TestSeeder::class);

    }
}
