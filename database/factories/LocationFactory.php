<?php

namespace Database\Factories;

use App\Models\Location;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory {

    protected $model = Location::class;

    /**
     * @inheritDoc
     */
    public function definition()
    {
        return [
            'device' => [],
            'uuid' => (string) $this->faker->unique()->uuid,
            'location' => (new Point($this->faker->latitude(), $this->faker->longitude())),
            'accuracy' => $this->faker->numberBetween(10,50),
            'altitude' => $this->faker->numberBetween(20,300),
            'speed' => $this->faker->numberBetween(0,100),
            'heading' => $this->faker->numberBetween(0,360),
            'odometer' => $this->faker->randomNumber(5),
            'event' => 'motionchange',
            'activity_type' => 'still',
            'activity_confidence' => 100,
            'battery_level' => $this->faker->numberBetween(1,100),
            'battery_is_charging' => true,
            'is_moving' => true,
            'generated_at' => time(),
        ];
    }
}
