<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Device;
use App\Location;
use App\Pet;
use App\PetLocation;
use App\User;
use App\UserLocation;
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

$factory->define(Location::class, function (Faker $faker) {
    return [
        'device' => [],
        'uuid' => $faker->uuid,
        'location' => (new Point($faker->latitude(), $faker->longitude())),
        'accuracy' => $faker->numberBetween(10,50),
        'altitude' => $faker->numberBetween(20,300),
        'speed' => $faker->numberBetween(0,100),
        'heading' => $faker->numberBetween(0,360),
        'odometer' => $faker->randomNumber(5),
        'event' => 'motionchange',
        'activity_type' => 'still',
        'activity_confidence' => 100,
        'battery_level' => $faker->numberBetween(1,100),
        'battery_is_charging' => true,
        'is_moving' => true,
        'generated_at' => time(),
    ];
});
