<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\User;
use App\Models\Department;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

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
            'nrp' => Str::random(10),
            'department_id' => Department::factory(),
            'user_id' => User::factory()
        ];
    }
}
