<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

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
            'name' => $this->faker->name,
            'username' => Str::random(10),
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
            'email_verified_at' => $this->faker->randomElement([null, $this->faker->dateTime($max = 'now', $timezone = null)]),
            'is_admin' => $this->faker->randomElement([false, true]),
            'photo' => Str::random(10).'.png'  
        ];
    }
}
