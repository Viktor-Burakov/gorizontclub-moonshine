<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContentBlock>
 */
class ContentBlockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->city . ' - ' . fake()->monthName()  . ' - ' . fake()->numberBetween(1,31);
        return [
           'name' => $name,
           'title' => $name,
           'description' => fake()->text(2000),
        ];
    }
}
