<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'rut' => $this->faker->regexify('[1-9][0-9]{6,7}-[0-9k]'),
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('1234567890'), // password
            'remember_token' => Str::random(10),
        ];
    }
}
