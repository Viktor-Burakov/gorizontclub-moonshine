<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory()->create([
            'slug' => 'splavy',
            'title' => 'Сплавы',
        ]);

        Category::factory()->create([
            'slug' => 'pohody',
            'title' => 'Походы',
        ]);

        Category::factory()->create([
            'slug' => 'konnye-pohody',
            'title' => 'Конные походы',
        ]);

        Category::factory()->create([
            'slug' => 'kayaking',
            'title' => 'Каякинг',
        ]);

        Category::factory()->create([
            'active' => 0,
            'slug' => 'gornolyzhnye-tury-iz-tyumeni',
            'title' => 'Горнолыжные выезды',
        ]);

        Category::factory()->create([
            'slug' => 'poleznoe',
            'title' => 'Полезное',
        ]);

        Category::factory()->create([
            'slug' => 'proshedshie',
            'title' => 'Прошедшие',
        ]);
    }
}
