<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subject::factory()
                ->hasLecturer(1)
                ->hasSchedules(2)
                ->hasStudents(10)
                ->make();
    }
}
