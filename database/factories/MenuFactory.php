<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Menu::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'priority' => $faker->randomDigit,
        'link' => $faker->url
    ];
});
