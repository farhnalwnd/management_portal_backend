<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ModulMgt>
 */
class ModulMgtFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'module_name' => $this->faker->word(),
            'module_description' => $this->faker->sentence(),
            'is_active' => $this->faker->boolean(),
            'category' => $this->faker->randomElement(['fico', 'mm', 'sd', 'pp', 'pm', 'hr']),
            'created_by' => \App\Models\User::factory(),
            'last_modified_by' => \App\Models\User::factory(),
        ];
    }
}
