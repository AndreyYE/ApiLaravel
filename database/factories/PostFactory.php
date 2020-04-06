<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\App\Models\Post::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'text' => $faker->text,
        'image' => null,
        'category_id' => \App\Models\Category::inRandomOrder()->select('id')->first(),
        'user_id' => \App\Models\User::inRandomOrder()->select('id')->first(),
    ];
});
