<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MenuMgt>
 */
class MenuMgtFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'menu_name' => $this->faker->word(),
            'module_id' => \App\Models\ModulMgt::factory(),
            'content_id' => \App\Models\ContentMgt::factory(),
            'display_order' => $this->faker->numberBetween(1, 20),
            'menu_level' => $this->faker->numberBetween(1, 11),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
