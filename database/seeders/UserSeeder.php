<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Seed 50 random users via factory
        User::factory(50)->create();

        // Ensure the test user always exists
        User::factory()->create([
            'email' => 'test@example.com',
        ]);
    }
}
