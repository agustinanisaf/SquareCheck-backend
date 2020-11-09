<?php

namespace Database\Factories;

use App\Models\Schedule;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Collection;
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
            'time' => $this->faker->dateTimeBetween($startDate = 'now', $endDate = '+4 months', $timezone = null),
            // 'start_time' => $this->faker->dateTime($max = 'now', $timezone = null),
            // 'end_time' => $this->faker->dateTime($max = 'now', $timezone = null),
        ];
    }

    public function recurring(int $recurring)
    {
        $sequences = [];
        $recurringWeeks = $this->recurringWeeks(
            $this->faker->dateTimeBetween($startDate = 'now', $endDate = '+1 weeks'),
            $recurring
        );
        foreach ($recurringWeeks as $week) {
            array_push($sequences, ['time' => $week]);
        }
        return $this->state(new Sequence(...$sequences));
    }

    public function recurringWeeks(\DateTime $dateTime, int $recurring)
    {
        $recurringWeeks = [$dateTime];
        $dateTimeClone = clone ($dateTime);
        for ($i = 1; $i < $recurring; $i++) {
            $dateTimeClone = date_modify($dateTimeClone, '+1 weeks');
            array_push($recurringWeeks, $dateTimeClone);
            $dateTimeClone = clone ($dateTimeClone);
        }
        return $recurringWeeks;
    }
}
