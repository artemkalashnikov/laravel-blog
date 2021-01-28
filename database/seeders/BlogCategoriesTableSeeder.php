<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [];

        for ($i = 0; $i <= 10; $i++) {
            $categoryName = $i == 0 ? 'Без категории' : 'Категория ' . $i;

            $categories[] = [
                'title'      =>  $categoryName,
                'slug'       => Str::slug($categoryName),
                'created_at' => now(),
            ];
        }

        \Illuminate\Support\Facades\DB::table('blog_categories')->insert($categories);
    }
}
