<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Photo;
use App\User;
use App\Comment;
use Faker\Generator as Faker;
use Grimzy\LaravelMysqlSpatial\Types\Point;

$factory->define(Photo::class, function (Faker $faker) {
    return [
        'uuid' => (string) $faker->uuid,
        'ext' => '.jpg',
        'location' => (new Point($faker->latitude(), $faker->longitude())),
        'user_id' => factory(User::class)->create()->id,
        'comment_id' => factory(Comment::class)->create()->id,
        'is_public' => true,
    ];
});
