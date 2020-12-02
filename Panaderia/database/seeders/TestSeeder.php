<?php

namespace Database\Seeders;


use App\Models\Client;
use App\Models\Dealer;
use App\Models\RawMaterial;
use Illuminate\Database\Seeder;
use App\Models\User;
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
        $faker = Factory::create();

        User::create([
            'name' => 'Admin',
            'lastname' => 'Test',
            'rut' => '11111111-1',
            'email' => 'admin@test.com',
            'password' => Hash::make('1234567890'),
        ])
            ->assignRole('admin');

        User::create([
            'name' => 'Aldo',
            'lastname' => 'Gonzalez',
            'rut' => '8105573-4',
            'email' => 'panlostresantonios@hotmail.com',
            'password' => Hash::make('1234567890'),
        ])
            ->assignRole('admin');

        $repartidor1 = Dealer::create([
            'name' => 'Repartidor',
            'lastname' => '1',
            'phone' => '+569'.$faker->numberBetween(20000000,99999999 ),
            'email' => $faker->unique()->safeEmail,
        ]);

        $repartidor2 = Dealer::create([
            'name' => 'Repartidor',
            'lastname' => '2',
            'phone' => '+569'.$faker->numberBetween(20000000,99999999 ),
            'email' => $faker->unique()->safeEmail,
        ]);

        $client1 = Client::Create([
            'name' => 'Cliente 1',
            'direction' => $faker->streetAddress,
            'phone' => '+569'.$faker->numberBetween(20000000,99999999 ),
        ]);

        $client1 = Client::Create([
            'name' => 'Cliente 2',
            'direction' => $faker->streetAddress,
            'phone' => '+569'.$faker->numberBetween(20000000,99999999 ),
        ]);
    
    }
}
