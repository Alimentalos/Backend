<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Coin;
use Faker\Generator as Faker;

$factory->define(Coin::class, function (Faker $faker) {
    return [
        'uuid' => (string) $faker->unique()->uuid,
        'amount' => $faker->numberBetween(1, 100000),
        'used' => false,
    ];
});
