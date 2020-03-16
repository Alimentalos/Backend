<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Demency\Relationships\Models\Device;
use Faker\Generator as Faker;
use Grimzy\LaravelMysqlSpatial\Types\Point;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Device::class, function (Faker $faker) {
    return [
        'name' => 'Device: #' . $faker->randomNumber(5),
        'location' => (new Point($faker->latitude(), $faker->longitude())),
        'description' => $faker->text(200),
        'uuid' => (string) $faker->unique()->uuid,
        'is_public' => true,
        'api_token' => (string) $faker->uuid,
    ];
});
