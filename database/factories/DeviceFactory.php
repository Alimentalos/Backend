<?php

namespace Database\Factories;

use App\Models\Device;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeviceFactory extends Factory {

    protected $model = Device::class;

    /**
     * @inheritDoc
     */
    public function definition()
    {
        return [
            'name' => 'Device: #' . $this->faker->randomNumber(5),
            'location' => (new Point($this->faker->latitude(), $this->faker->longitude())),
            'description' => $this->faker->text(200),
            'uuid' => (string) $this->faker->unique()->uuid,
            'is_public' => true,
            'api_token' => (string) $this->faker->uuid,
        ];
    }
}
