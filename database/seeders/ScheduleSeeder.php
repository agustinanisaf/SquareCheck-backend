<?php

namespace Database\Seeders;

use App\Models\Schedule;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects = Subject::all()->pluck('id')->toArray();

        foreach ($subjects as $subject) {
            Schedule::factory()
                ->count(16)
                ->recurring(16)
                ->create([
                    'subject_id' => $subject
                ]);
        }
    }
}
