<?php

namespace Database\Seeders;

use App\Models\StudentAttendance;
use Illuminate\Database\Seeder;

class StudentAttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudentAttendance::factory()
            ->create();
    }
}
