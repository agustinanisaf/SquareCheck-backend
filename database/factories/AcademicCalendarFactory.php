<?php

namespace Database\Factories;

use App\Models\AcademicCalendar;
use App\Models\AcademicCalendarType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AcademicCalendarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AcademicCalendar::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $types = AcademicCalendarType::all()->pluck('id')->toArray();
        $startDateTime = $this->faker->dateTimeBetween($startDate = 'now', $endDate = '+1 years');
        $startDateTimeClone = clone $startDateTime;
        $endDateTime = $this->faker->dateTimeBetween($startDateTime, $startDateTimeClone->modify('+3 months'));

        return [
            'name' => $this->faker->name,
            'description' => $this->faker->paragraph(2),
            'type' => $this->faker->randomElement($types),
            'start_date' => $startDateTime->format("Y-m-d"),
            'end_date' => $endDateTime->format("Y-m-d"),
        ];
    }
}
