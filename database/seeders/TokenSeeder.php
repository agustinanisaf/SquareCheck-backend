<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Token;

class TokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Token::factory()
                ->times(10)
                ->hasUser(1)
                ->make();
    }
}
