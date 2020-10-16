<?php

namespace Database\Factories;

use App\Models\Schedule;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Schedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'subject_id' => Subject::factory(),
            'time' => $this->faker->dateTime($max = 'now', $timezone = null),
            'start_time' => $this->faker->dateTime($max = 'now', $timezone = null),
            'end_time' => $this->faker->dateTime($max = 'now', $timezone = null),
        ];
    }
}
