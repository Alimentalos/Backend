<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Group;
use App\Photo;
use App\User;
use Faker\Generator as Faker;

$factory->define(Group::class, function (Faker $faker) {
    return [
        'name' => $faker->text(6),
        'user_id' => factory(User::class)->create()->id,
        'photo_id' => factory(Photo::class)->create()->id,
        'uuid' => $faker->uuid,
        'is_public' => true,
    ];
});
