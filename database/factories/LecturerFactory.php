<?php

namespace Database\Factories;

use App\Models\Lecturer;
use App\Models\User;
use App\Models\Department;
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
        return [
            'name' => $this->faker->name,
            'nip' => strval(rand(1000000000, 9999999999)),
            'department_id' => Department::factory(),
            'user_id' => User::factory()->create(['role' => 'lecturer'])
        ];
    }
}
