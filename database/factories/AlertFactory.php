<?php

/** @var Factory $factory */

use App\Alert;
use App\Device;
use App\Pet;
use App\Photo;
use App\Repositories\AlertsRepository;
use App\Repositories\StatusRepository;
use App\Repositories\TypeRepository;
use App\User;
use Faker\Generator as Faker;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Alert::class, function (Faker $faker) {
    $class = $faker->randomElement(AlertsRepository::availableAlertTypes());
    $alert_id = (
        $class === 'App\\User' ?
            factory(User::class)->create()->id :
            (
                $class === 'App\\Pet' ? factory(Pet::class)->create()->id : factory(Device::class)->create()->id
            )
    );
    return [
        'uuid' => (string) $faker->uuid,
        'user_id' => factory(User::class)->create()->id,
        'photo_id' => factory(Photo::class)->create()->id,
        'photo_url' => config('storage.path') . 'example.png',
        'location' => (new Point($faker->latitude(), $faker->longitude())),
        'alert_type' => $class,
        'alert_id' => $alert_id,
        'title' => $faker->sentence($faker->numberBetween(5, 10)),
        'body' => $faker->sentence($faker->numberBetween(50, 200)),
        'status' => $faker->randomElement(StatusRepository::availableAlertStatuses()),
        'type' => $faker->randomElement(TypeRepository::availableAlertTypes()),
    ];
});
