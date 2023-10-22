<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->country;

        return [
            'title' => $title,
            'h1' => $title . '-H1',
            'description' => fake()->text(300),
            'preview_text' => fake()->text(150),
            'preview_alt' => fake()->text(150),
            'date_start' => fake()->dateTimeInInterval('+1 years +1 mounts', '+10 day'),
            'date_end' => fake()->dateTimeInInterval('+1 years', '+10 day'),
        ];
    }
}
