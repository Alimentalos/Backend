<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Action;
use App\User;
use Faker\Generator as Faker;

$factory->define(Action::class, function (Faker $faker) {
    return [
        'uuid' => (string) $faker->uuid,
        'user_id' => factory(User::class)->create()->id,
        'referenced_id' => factory(User::class)->create()->id,
        'resource' => 'Sample',
        'type' => $faker->randomElement(['success', 'failed', 'rejected']),
        'parameters' => [
            'some-parameter' => $faker->numberBetween(0, 1000),
            'another-parameter' => (string) $faker->unique()->uuid,
            'awesome-parameter' => $faker->sentence($faker->numberBetween(10, 40))
        ],
    ];
});
