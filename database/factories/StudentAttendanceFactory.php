<?php

namespace Database\Factories;

use App\Models\Schedule;
use App\Models\Student;
use App\Models\StudentAttendance;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StudentAttendanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StudentAttendance::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'schedule_id' => Schedule::factory(),
            'student_id' => Student::factory(),
            'time' => $this->faker->dateTime($max = 'now', $timezone = null),
            'status' => $this->faker->randomElement(['hadir', 'izin', 'terlambat', 'alpa']),
        ];
    }
}
