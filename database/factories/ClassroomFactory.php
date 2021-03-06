<?php

namespace Database\Factories;

use App\Models\Classroom;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClassroomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Classroom::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $tingkat = mt_rand(1, 3);
        $jenisStudi = ["D", "S"]; //Diploma and Sarjana
        $prodi = ["Cyber Security", "Teknik Telekomunikasi", "Teknik Mekatronika", "Teknik Elektronika", "Sistem Informasi Bisnis"];
        $name = mt_rand(1, $tingkat) . " " .
            $this->faker->randomElement($jenisStudi) .
            $tingkat . " " . $this->faker->randomElement($prodi) . " " .
            $this->faker->randomElement(['A', 'B', 'C', 'D']);

        return [
            'name' => $name,
        ];
    }
}
