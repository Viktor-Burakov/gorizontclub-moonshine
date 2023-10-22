<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        DB::table('moonshine_users')->insert([
            'name' => 'admin',
            'password' => '$2y$10$JjkDbUtdJVwSFo9jqAL9XeTD2NGa3DtslOZEAolAfzQiFwfX6Z.TC',
            'email' => 'admin',
        ]);

        $category = [
            [
                'active' => 1,
                'url' => 'splavy',
                'title' => 'Сплавы',
            ],
            [
                'active' => 1,
                'url' => 'pohody',
                'title' => 'Походы',
            ],
            [
                'active' => 1,
                'url' => 'konnye-pohody',
                'title' => 'Конные походы',
            ],
            [
                'active' => 1,
                'url' => 'kayaking',
                'title' => 'Каякинг',
            ],
            [
                'url' => 'gornolyzhnye-tury-iz-tyumeni',
                'title' => 'Горнолыжные выезды',
            ],
            [
                'active' => 1,
                'url' => 'poleznoe',
                'title' => 'Полезное',
            ],
            [
                'active' => 1,
                'url' => 'proshedshie',
                'title' => 'Прошедшие',
            ],
        ];
        foreach ($category as $value) {
            DB::table('categories')->insert($value);
        }

        $posts = [
            [
                'active' => 1,
                'title' => 'post1',
                'url' => 'post1',
                'h1' => 'post1 - h1',
                'date_start' => '2023-10-18T20:00',
                'date_end' => '2023-10-27T21:39',
            ],
            [
                'active' => 1,
                'title' => 'post2',
                'url' => 'post2',
                'h1' => 'post2- h1',
                'date_start' => '2023-11-18T20:00',
                'date_end' => '2023-11-27T21:39',
            ],
            [
                'active' => 1,
                'title' => 'post3',
                'url' => 'post3',
                'h1' => 'post3- h1',
                'date_start' => '2023-11-18T21:00',
                'date_end' => '2023-11-21T21:39',
            ],
            [
                'title' => 'post4',
                'url' => 'post4',
                'h1' => 'post4- h1',
                'date_start' => '2023-11-18T21:00',
                'date_end' => '2023-11-21T23:00',
            ],

        ];
        foreach ($posts as $value) {
            DB::table('posts')->insert($value);
        }

        $categoryPost = [
            [
                'post_id' => '1',
                'category_id' => '1',
            ],
            [
                'post_id' => '1',
                'category_id' => '3',
            ],
            [
                'post_id' => '1',
                'category_id' => '2',
            ],
            [
                'post_id' => '2',
                'category_id' => '2',
            ],
            [
                'post_id' => '2',
                'category_id' => '4',
            ],
            [
                'post_id' => '3',
                'category_id' => '2',
            ],
            [
                'post_id' => '4',
                'category_id' => '2',
            ],

        ];
        foreach ($categoryPost as $value) {
            DB::table('category_posts')->insert($value);
        }
        \App\Models\Post::factory(20)->create();
    }
}
