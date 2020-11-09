<?php

namespace Database\Factories;

use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Lecturer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SubjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subject::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $subjects = ['Mobile Programming', 'Mathematic', 'Software Development', 'Computer Graphic'];

        return [
            'name' => $this->faker->randomElement($subjects),
            'lecturer_id' => function (array $attributes) {
                $lecturers = Lecturer::where('department_id', Classroom::find($attributes['classroom_id'])->department_id)->pluck('id')->toArray();
                return $this->faker->randomElement($lecturers);
            },
            'classroom_id' => Classroom::factory(),
        ];
    }
}
