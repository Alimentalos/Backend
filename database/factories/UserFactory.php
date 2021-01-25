<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;
use Grimzy\LaravelMysqlSpatial\Types\Point;

class UserFactory extends Factory {

    protected $model = User::class;

    /**
     * @inheritDoc
     */
    public function definition()
    {
        $now = Date::now();
        return [
            'name' => $this->faker->name,
            'uuid' => (string) $this->faker->unique()->uuid,
            'photo_url' => config('storage.path') . (string) $this->faker->uuid . '.png',
            'email' => $this->faker->unique()->safeEmail,
            'location' => (new Point($this->faker->latitude(), $this->faker->longitude())),
            'email_verified_at' => $now,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'api_token' => $this->faker->uuid,
            'remember_token' => Str::random(10),
            'created_at' => $now,
            'free' => false,
            'is_public' => true,
        ];
    }
}
