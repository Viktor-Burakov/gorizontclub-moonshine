<?php

namespace Database\Seeders;

use App\Models\ContentBlock;
use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContentBlockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContentBlock::factory(6)
            ->hasAttached(Image::factory(1))
            ->create();
        ContentBlock::factory(2)
            ->create();
    }

}
