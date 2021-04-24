<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = collect(
            [
                [
                    'name' => 'Admins\'s topics',
                    'description' => 'Topics, created by admins',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'Users\'s topics',
                    'description' => 'Topics, created by users',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);


        $categories->each(function ($category) {
            Category::create($category);
        });
    }
}
