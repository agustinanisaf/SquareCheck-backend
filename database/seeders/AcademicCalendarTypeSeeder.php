<?php

namespace Database\Seeders;

use App\Models\AcademicCalendarType;
use Illuminate\Database\Seeder;

class AcademicCalendarTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AcademicCalendarType::factory()->create();
    }
}
