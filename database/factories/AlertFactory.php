<?php

namespace Database\Factories;

use Alimentalos\Relationships\Models\Alert;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlertFactory extends Factory {

    protected $model = Alert::class;

    /**
     * @inheritDoc
     */
    public function definition()
    {
        return [
            'uuid' => (string) $this->faker->unique()->uuid,
            'photo_url' => config('storage.path') . 'example.png',
            'location' => (new Point($this->faker->latitude(), $this->faker->longitude())),
            'title' => $this->faker->sentence($this->faker->numberBetween(5, 10)),
            'body' => $this->faker->sentence($this->faker->numberBetween(50, 200)),
            'status' => $this->faker->randomElement(cataloger()->types()),
            'type' => $this->faker->randomElement(alerts()->types()),
        ];
    }
}
