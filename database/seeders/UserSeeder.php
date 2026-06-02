<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create 10 active users
        User::factory(10)->active()->create();

        // Create 10 inactive users
        User::factory(10)->inactive()->create();

        // Create 5 locked users
        User::factory(5)->locked()->create();

        // Create 25 random users
        User::factory(25)->create();
    }
}
