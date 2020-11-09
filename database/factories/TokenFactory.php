<?php

namespace Database\Factories;

use App\Models\Token;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TokenFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Token::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_ids = User::all()->pluck('id')->toArray();

        return [
            'user_id' => $this->faker->randomElement($user_ids),
            'token' => Str::random(10),
            'type' => $this->faker->unique()->randomElement(['forget', 'refresh', 'fcm_token']),
        ];
    }
}
