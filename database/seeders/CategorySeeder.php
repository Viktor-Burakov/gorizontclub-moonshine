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
            'url' => 'splavy',
            'title' => 'Сплавы',
        ]);

        Category::factory()->create([
            'url' => 'pohody',
            'title' => 'Походы',
        ]);

        Category::factory()->create([
            'url' => 'konnye-pohody',
            'title' => 'Конные походы',
        ]);

        Category::factory()->create([
            'url' => 'kayaking',
            'title' => 'Каякинг',
        ]);

        Category::factory()->create([
            'active' => 0,
            'url' => 'gornolyzhnye-tury-iz-tyumeni',
            'title' => 'Горнолыжные выезды',
        ]);

        Category::factory()->create([
            'url' => 'poleznoe',
            'title' => 'Полезное',
        ]);

        Category::factory()->create([
            'url' => 'proshedshie',
            'title' => 'Прошедшие',
        ]);
    }
}
