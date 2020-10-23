<?php

namespace Database\Seeders;

use App\Models\AcademicCalendar;
use App\Models\AcademicCalendarType;
use Illuminate\Database\Seeder;

class AcademicCalendarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AcademicCalendar::factory()
            ->create();
    }
}
