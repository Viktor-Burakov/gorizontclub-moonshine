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
        $title = fake()->country . ' | ' . fake()->address() . ' | ' . fake()->date;
        $slug = str_slug($title);
        $date_start = fake()->dateTimeBetween('+1 month', '+3 month');
        $date_end = fake()->dateTimeBetween($date_start, $date_start->format('Y-m-d H:i:s') . ' +10 days');

        return [
            'active' => fake()->boolean,
            'title' => $title,
            'slug' => $slug,
            'h1' => $title . '-H1',
            'description' => fake()->text(300),
            'preview_text' => fake()->text(400),
            'preview' => $slug . '.jpg',
            'preview_alt' => fake()->text(150),
            'date_start' => $date_start,
            'date_end' => $date_end,
        ];
    }
}
