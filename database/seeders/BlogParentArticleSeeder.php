<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BlogParentArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 100; $i++) {
            $parent_id  =   rand(1, 100);
            $child_id   =   rand(1, 100);

            if ($parent_id !== $child_id) {
                $relations[] = [
                    'parent_id' =>  $parent_id,
                    'child_id'  =>  $child_id,
                ];
            }
        }

        \Illuminate\Support\Facades\DB::table('blog_parent_article')->insert($relations);
    }
}
