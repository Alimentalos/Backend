<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Alimentalos\Relationships\Models\Photo;
use Faker\Generator as Faker;
use Grimzy\LaravelMysqlSpatial\Types\Point;

$factory->define(Photo::class, function (Faker $faker) {
    return [
        'uuid' => (string) $faker->unique()->uuid,
        'ext' => '.png',
        'photo_url' => config('storage.path') . (string) $faker->uuid . '.png',
        'location' => (new Point($faker->latitude(), $faker->longitude())),
        'is_public' => true,
    ];
});
