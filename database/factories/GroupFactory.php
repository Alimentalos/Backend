<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Demency\Relationships\Models\Group;
use Faker\Generator as Faker;

$factory->define(Group::class, function (Faker $faker) {
    return [
        'name' => $faker->text(6),
        'uuid' => (string) $faker->unique()->uuid,
        'is_public' => true,
    ];
});
