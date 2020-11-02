<?php

namespace Database\Factories;

use App\Models\Classroom;
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
        $classrooms = Classroom::all()->pluck('id')->toArray();
        $departments = Department::all()->pluck('id')->toArray();

        return [
            'name' => $faker_id->name,
            'nrp' => strval(rand(1000000000, 9999999999)),
            'department_id' => $this->faker->randomElement($departments),
            'user_id' => User::factory()->create(['role' => 'student']),
            'classroom_id' => $this->faker->randomElement($classrooms),
        ];
    }
}
