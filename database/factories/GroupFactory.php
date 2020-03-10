<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Group;
use App\Photo;
use App\User;
use Faker\Generator as Faker;

$factory->define(Group::class, function (Faker $faker) {
    return [
        'name' => $faker->text(6),
        'user_uuid' => factory(User::class)->create()->uuid,
        'photo_uuid' => factory(Photo::class)->create()->uuid,
        'uuid' => (string) $faker->uuid,
        'is_public' => true,
    ];
});
