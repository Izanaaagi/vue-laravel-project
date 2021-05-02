<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Topic;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        Topic::factory()->count(10)->create();
        Category::find(2)
            ->update([
                'posts' => Topic::where('category_id', 2)->count()
            ]);
    }
}
