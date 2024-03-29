<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->city . ' | ' . fake()->streetName() . ' | ' . fake()->date;
        $slug = str_slug($name);
        return [
            'name' => $name,
            'alt' => $name,
            'path' => $slug,
            'slug' => $slug . '.jpg',
        ];
    }
}
