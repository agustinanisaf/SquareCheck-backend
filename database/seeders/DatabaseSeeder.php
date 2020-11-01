<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // UserSeeder::class,
            // TokenSeeder::class,
            // DepartmentSeeder::class,
            // LecturerSeeder::class,
            // StudentSeeder::class,
            // ScheduleSeeder::class,
            // SubjectSeeder::class,
            // StudentAttendanceSeeder::class,
            AcademicCalendarTypeSeeder::class,
        ]);
    }
}
