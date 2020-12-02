<?php

namespace Database\Seeders;


use App\Models\Client;
use App\Models\Dealer;
use App\Models\Product;
use App\Models\ProductRawMaterial;
use App\Models\RawMaterial;
use App\Models\TypeMeasure;
use App\Models\TypeProduct;
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
        
        $measure1 = TypeMeasure::Create([
            'name' => 'Kilos',
        ]);

        $measure2 = TypeMeasure::Create([
            'name' => 'Litros',
        ]);

        $measure3 = TypeMeasure::Create([
            'name' => 'Quintales',
        ]);

        $measure4 = TypeMeasure::Create([
            'name' => 'Unidad',
        ]);

        $material1 = RawMaterial::Create([
            'name' => 'Harina',
            'stock' => $faker->numberBetween(1,100 ),
            'cost' =>   $faker->numberBetween(1000,50000),
            'type_measure_id' => $measure3->id,
        ]);
    
        $material2 = RawMaterial::Create([
            'name' => 'Mantequilla',
            'stock' => $faker->numberBetween(1,100 ),
            'cost' =>   $faker->numberBetween(1000,50000),
            'type_measure_id' => $measure1->id,
        ]);

        $material3 = RawMaterial::Create([
            'name' => 'Aceite',
            'stock' => $faker->numberBetween(1,100 ),
            'cost' =>   $faker->numberBetween(1000,50000),
            'type_measure_id' => $measure2->id,
        ]);
        
        $typeProduct = TypeProduct::Create([
            'name' => 'Masas',
        ]);

        $product = Product::create([
            'name' => 'Pan',
            'type_product_id' => $typeProduct->id,
            'type_measure_id' => $measure1->id,
        ]);

        ProductRawMaterial::Create([
            'product_id' => $product->id,
            'raw_material_id' => $material1->id,
            'quantity' => $faker->numberBetween(1,10 ),
        ]);

        ProductRawMaterial::Create([
            'product_id' => $product->id,
            'raw_material_id' => $material2->id,
            'quantity' => $faker->numberBetween(1,10 ),
        ]);
    }
}
