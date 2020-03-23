<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Alimentalos\Relationships\Models\Action;
use Faker\Generator as Faker;

$factory->define(Action::class, function (Faker $faker) {
    return [
        'uuid' => (string) $faker->unique()->uuid,
        'resource' => 'Sample',
        'type' => $faker->randomElement(['success', 'failed', 'rejected']),
        'parameters' => [
            'some-parameter' => $faker->numberBetween(0, 1000),
            'another-parameter' => (string) $faker->unique()->uuid,
            'awesome-parameter' => $faker->sentence($faker->numberBetween(10, 40))
        ],
    ];
});
