<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'videographer',
            'video editor',
            'photographer',
            'content writing',
            'copywriting',
            'translator',
            'ui design',
            'front-end',
            'back-end',
            'fullstack',
            'graphic design',
            'illustrator',
        ];

        foreach ($categories as $name) {
            Category::firstOrCreate(['name' => $name]);
    }
}
}
