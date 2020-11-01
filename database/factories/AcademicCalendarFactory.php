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
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->paragraph(2),
            'type' => $this->faker->randomElement($types),
            'date' => $this->faker->date,
        ];
    }
}
