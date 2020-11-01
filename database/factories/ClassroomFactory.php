<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

namespace Database\Factories;

use App\Models\Classroom;
use Faker\Generator as Faker;
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
        $jenisStudi = array("D, S");
        $prodi = array("Cyber Security", "Telekomunikasi", "Mekatronika", "Elektronika", "Sistem Informasi Bisnis");
        $name = mt_rand(1, $tingkat) . " " .
            $this->faker->randomElement($jenisStudi) .
            $tingkat . " " . $this->faker->randomElement($prodi) . " " .
            $this->faker->randomElement('A', 'B', 'C', 'D');

        return [
            'name' => $name,
        ];
    }
}
