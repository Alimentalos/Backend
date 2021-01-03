<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Passport\Client;

class PassportClientFactory extends Factory {

    protected $model = Client::class;

    /**
     * @inheritDoc
     */
    public function definition()
    {
        return [
            'user_id' => null,
            'name' => $this->faker->company,
            'secret' => Str::random(40),
            'redirect' => $this->faker->url,
            'personal_access_client' => false,
            'password_client' => false,
            'revoked' => false,
        ];
    }
}

//$factory->state(Client::class, 'password_client', function (Faker $this->faker) {
//    return [
//        'personal_access_client' => false,
//        'password_client' => true,
//    ];
//});
