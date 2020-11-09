<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prodi = ["Cyber Security", "Teknik Telekomunikasi", "Teknik Mekatronika", "Teknik Elektronika", "Sistem Informasi Bisnis"];

        foreach ($prodi as $p) {
            Department::factory()
                ->hasLecturers(10)
                ->create(['name' => $p]);
        }
    }
}
