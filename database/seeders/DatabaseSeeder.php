<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\ContentBlock;
use App\Models\Image;
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
        $contentBlocks = ContentBlock::all();
        $images = Image::all();

        $posts = Post::all()->each(function ($post) use ($images, $contentBlocks, $categories) {
            $post->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );
            $post->contentBlocks()->attach(
                $contentBlocks->random(rand(0, 3))->pluck('id')->toArray()
            );
            $post->images()->attach(
                $images->random(rand(1, 5))->pluck('id')->toArray()
            );
        });

    }
}

