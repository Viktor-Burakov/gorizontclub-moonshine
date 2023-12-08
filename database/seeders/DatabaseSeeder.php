<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\ContentBlock;
use App\Models\Post;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            PostSeeder::class,
            ImageSeeder::class,
        ]);

        $categories = Category::all();


        $posts = Post::all()->each(function ($post) use ($categories) {
            $post->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );
        });

        ContentBlock::all()->each(function ($contentBlock) use ($posts) {
            $contentBlock->posts()->attach(
                $posts->random(rand(0, 3))->pluck('id')->toArray()
            );
        });

    }
}

