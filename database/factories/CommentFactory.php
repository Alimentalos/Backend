<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use App\User;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()->id,
        'uuid' => (string) $faker->uuid,
        'title' => $faker->sentence($faker->numberBetween(5, 8)),
        'body' => $faker->sentence($faker->numberBetween(40, 100)),
    ];
});
