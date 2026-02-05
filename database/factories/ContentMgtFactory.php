<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\content_mgt>
 */
class ContentMgtFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->word(),
            'title' => $this->faker->sentence(),
            'modul_id' => \App\Models\ModulMgt::factory(),
            'version' => $this->faker->numerify('v#.##'),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'repo' => $this->faker->url(),
            'created_by' => \App\Models\User::factory(),
            'last_modified_by' => \App\Models\User::factory(),
            'published_by' => \App\Models\User::factory(),
            'published_date' => $this->faker->date(),
            'approver_id' => \App\Models\User::factory(),
            'approval_status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
        ];
    }
}
