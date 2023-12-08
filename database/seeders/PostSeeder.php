<?php

namespace Database\Seeders;

use App\Models\ContentBlock;
use App\Models\Image;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory()
            ->hasAttached(
                ContentBlock::factory(4)
                    ->hasAttached(Image::factory(1))
            )
            ->hasAttached(Image::factory(3))
            ->create([
            'active' => 1,
            'title' => 'post1',
            'h1' => 'post1 - h1',
            'date_start' => fake()->dateTimeBetween('next Friday', 'next Friday +3 days'),
            'date_end' => fake()->dateTimeBetween('next Friday +4 days', 'next Friday +10 days'),
        ]);

        Post::factory()
            ->hasAttached(
                ContentBlock::factory(4)
                    ->hasAttached(Image::factory(2))
            )
            ->hasAttached(Image::factory(3))
            ->create([
            'active' => 1,
            'title' => 'post2',
            'h1' => 'post2- h1',
            'date_start' => fake()->dateTimeBetween('next Friday', 'next Friday +3 days'),
            'date_end' => fake()->dateTimeBetween('next Friday +4 days', 'next Friday +10 days'),
        ]);

        Post::factory()
            ->hasAttached(
                ContentBlock::factory(4)
                    ->hasAttached(Image::factory(3))
            )
            ->hasAttached(Image::factory(3))
            ->create([
            'active' => 1,
            'title' => 'post3',
            'h1' => 'post3- h1',
            'date_start' => fake()->dateTimeBetween('next Friday', 'next Friday +3 days'),
            'date_end' => fake()->dateTimeBetween('next Friday +4 days', 'next Friday +10 days'),
        ]);

        Post::factory()
            ->hasAttached(
                ContentBlock::factory(4)
                    ->hasAttached(Image::factory(4))
            )
            ->hasAttached(Image::factory(5))
            ->create([
            'active' => 1,
            'title' => 'post4',
            'h1' => 'post4- h1',
            'date_start' => fake()->dateTimeBetween('next Friday', 'next Friday +3 days'),
            'date_end' => fake()->dateTimeBetween('next Friday +4 days', 'next Friday +10 days'),
        ]);

        Post::factory(6)
            ->hasAttached(
                ContentBlock::factory(3)
                    ->hasAttached(Image::factory(1))
            )
            ->hasAttached(Image::factory(2))
            ->create();
    }
}
