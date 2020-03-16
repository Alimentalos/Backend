<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Demency\Relationships\Models\Operation;
use Faker\Generator as Faker;

$factory->define(Operation::class, function (Faker $faker) {
    return [
        'uuid' => (string) $faker->unique()->uuid,
        'status' => $faker->numberBetween(0, 1),
        'amount' => $faker->numberBetween(1, 100000),
    ];
});
