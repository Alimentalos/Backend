<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Pet;
use App\Photo;
use App\User;
use Faker\Generator as Faker;
use Grimzy\LaravelMysqlSpatial\Types\Point;

$factory->define(Pet::class, function (Faker $faker) {
    return [
        'name' => $faker->text(6),
        'uuid' => (string) $faker->uuid,
        'location' => (new Point($faker->latitude(), $faker->longitude())),
        'user_uuid' => factory(User::class)->create()->uuid,
        'photo_uuid' => factory(Photo::class)->create()->uuid,
        'description' => $faker->uuid,
        'hair_color' => $faker->hexColor,
        'left_eye_color' => $faker->hexColor,
        'right_eye_color' => $faker->hexColor,
        'api_token' =>  (string) $faker->unique()->uuid,
        'size' => $faker->randomElement(['xs', 's', 'm', 'l', 'xl']),
        'born_at' => now(),
        'is_public' => true,
    ];
});
