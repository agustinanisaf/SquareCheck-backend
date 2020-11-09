<?php

namespace Database\Factories;

use App\Models\Lecturer;
use App\Models\User;
use App\Models\Department;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LecturerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lecturer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker_id = Faker::create('id_ID');

        return [
            'name' => $faker_id->name,
            'nip' => strval(rand(1000000000, 9999999999)),
            'department_id' => Department::factory(),
            'user_id' => function (array $attributes) {
                return User::factory()->create([
                    'name' => $attributes['name'],
                    'role' => 'lecturer'
                ]);
            },
        ];
    }
}
