<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Department;
use Illuminate\Database\Seeder;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = Department::all();

        foreach ($departments as $department) {
            $tingkat = range(1, 4);
            $jenisStudi = ['D3', 'D4'];
            $kelas = ['A', 'B'];
            $collection = collect($tingkat);
            $collection = $collection->crossJoin($jenisStudi, $department->name, $kelas);
            foreach ($collection->all() as $name) {
                if ($name[1] == 'D3' && $name[0] == 4) {
                    continue;
                }
                Classroom::factory()
                    ->hasStudents(30, [
                        'department_id' => $department->id
                    ])
                    ->hasSubjects(10)
                    ->create([
                        'name' => implode(' ', $name),
                        'slug' => $this->nameSlugify(implode(' ', $name)),
                        'department_id' => $department->id
                    ]);
            }
        }
    }

    public function nameSlugify($name)
    {
        $fragments = explode(" ", $name);
        $major = "";
        $slug = "";
        foreach ($fragments as $fragment) {
            if (strlen($fragment) <= 2) {
                if ($major != "")
                    $slug .= $major . " ";
                $slug .= $fragment;
            } else {
                $major .= substr($fragment, 0, 1);
                continue;
            }
            $slug .= " ";
        }

        return trim($slug);
    }
}
