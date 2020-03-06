<?php

/** @var Factory $factory */

use App\Alert;
use App\Device;
use App\Pet;
use App\Photo;
use App\User;
use Faker\Generator as Faker;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Alert::class, function (Faker $faker) {
    $class = $faker->randomElement(alerts()->alert_types());
    $alert_id = (
        $class === 'App\\User' ?
            factory(User::class)->create()->uuid :
            (
                $class === 'App\\Pet' ? factory(Pet::class)->create()->uuid : factory(Device::class)->create()->uuid
            )
    );
    return [
        'uuid' => (string) $faker->uuid,
        'user_uuid' => factory(User::class)->create()->uuid,
        'photo_uuid' => factory(Photo::class)->create()->uuid,
        'photo_url' => config('storage.path') . 'example.png',
        'location' => (new Point($faker->latitude(), $faker->longitude())),
        'alert_type' => $class,
        'alert_id' => $alert_id,
        'title' => $faker->sentence($faker->numberBetween(5, 10)),
        'body' => $faker->sentence($faker->numberBetween(50, 200)),
        'status' => $faker->randomElement(cataloger()->types()),
        'type' => $faker->randomElement(alerts()->types()),
    ];
});
