<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Category::class,5)->create()->each(function($category)
        {
            $category->create(factory(\App\Models\Category::class)->make(['parent_id' => $category->id])->toArray());
        });
    }
}
