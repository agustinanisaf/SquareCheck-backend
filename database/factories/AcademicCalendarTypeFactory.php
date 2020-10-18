<?php

namespace Database\Factories;

use App\Models\AcademicCalendarType;
use Illuminate\Database\Eloquent\Factories\Factory;

class AcademicCalendarTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AcademicCalendarType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name
        ];
    }
}
