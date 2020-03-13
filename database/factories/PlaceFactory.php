<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Pet;
use App\Photo;
use App\Place;
use App\User;
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
