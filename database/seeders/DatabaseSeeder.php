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
            //already working^^^
            UserSeeder::class,
            DepartmentSeeder::class, //also generate 10 lecturer
            AcademicCalendarTypeSeeder::class, //also generate 3 academic calendar
            // TokenSeeder::class,
            ClassroomSeeder::class,
            // LecturerSeeder::class,
            // StudentSeeder::class,
            ScheduleSeeder::class,
            // SubjectSeeder::class,
            // StudentAttendanceSeeder::class,
        ]);
    }
}
