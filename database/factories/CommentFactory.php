<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Alimentalos\Relationships\Models\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'uuid' => (string) $faker->unique()->uuid,
        'title' => $faker->sentence($faker->numberBetween(5, 8)),
        'body' => $faker->sentence($faker->numberBetween(40, 100)),
    ];
});
