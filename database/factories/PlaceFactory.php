<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Alimentalos\Relationships\Models\Place;
use Faker\Generator as Faker;
use Grimzy\LaravelMysqlSpatial\Types\Point;

$factory->define(Place::class, function (Faker $faker) {
    return [
        'name' => $faker->text(6),
        'uuid' => (string) $faker->unique()->uuid,
        'location' => (new Point($faker->latitude(), $faker->longitude())),
        'description' =>  $faker->text(30),
    ];
});
