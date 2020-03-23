<?php

/** @var Factory $factory */

use Alimentalos\Relationships\Models\Alert;
use Faker\Generator as Faker;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Alert::class, function (Faker $faker) {
    return [
        'uuid' => (string) $faker->unique()->uuid,
        'photo_url' => config('storage.path') . 'example.png',
        'location' => (new Point($faker->latitude(), $faker->longitude())),
        'title' => $faker->sentence($faker->numberBetween(5, 10)),
        'body' => $faker->sentence($faker->numberBetween(50, 200)),
        'status' => $faker->randomElement(cataloger()->types()),
        'type' => $faker->randomElement(alerts()->types()),
    ];
});
