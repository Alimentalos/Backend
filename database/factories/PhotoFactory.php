<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Photo;
use App\User;
use App\Comment;
use Faker\Generator as Faker;
use Grimzy\LaravelMysqlSpatial\Types\Point;

$factory->define(Photo::class, function (Faker $faker) {
    return [
        'uuid' => uuid(),
        'ext' => '.png',
        'photo_url' => config('storage.path') . (string) $faker->uuid . '.png',
        'location' => (new Point($faker->latitude(), $faker->longitude())),
        'user_uuid' => factory(User::class)->create()->uuid,
        'comment_uuid' => factory(Comment::class)->create()->uuid,
        'is_public' => true,
    ];
});
