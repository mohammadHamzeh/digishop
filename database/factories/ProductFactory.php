<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Shop\Product::class, function (Faker $faker) {
    return [
        'title'=>$faker->title,
        'description'=>$faker->text
    ];
});
