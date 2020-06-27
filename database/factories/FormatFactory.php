<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Format;
use Faker\Generator as Faker;

$factory->define(Format::class, function (Faker $faker) {
    return [
        'edition'=>$faker->word,
        'price'=>$faker->randomFloat(2, 150, 300),
        'image'=>$faker->imageUrl(400, 400),
    ];
});
