<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Action;
use App\User;
use Faker\Generator as Faker;

$factory->define(Action::class, function (Faker $faker) {
    return [
        'uuid' => uuid(),
        'user_uuid' => factory(User::class)->create()->uuid,
        'referenced_uuid' => factory(User::class)->create()->uuid,
        'resource' => 'Sample',
        'type' => $faker->randomElement(['success', 'failed', 'rejected']),
        'parameters' => [
            'some-parameter' => $faker->numberBetween(0, 1000),
            'another-parameter' => (string) $faker->unique()->uuid,
            'awesome-parameter' => $faker->sentence($faker->numberBetween(10, 40))
        ],
    ];
});
