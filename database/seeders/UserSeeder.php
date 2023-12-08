<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('moonshine_users')->insert([
            'name' => 'admin',
            'password' => '$2y$10$JjkDbUtdJVwSFo9jqAL9XeTD2NGa3DtslOZEAolAfzQiFwfX6Z.TC',
            'email' => 'admin',
        ]);
    }
}
