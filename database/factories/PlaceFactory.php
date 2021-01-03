<?php

namespace Database\Factories;

use Alimentalos\Relationships\Models\Place;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlaceFactory extends Factory {

    protected $model = Place::class;

    /**
     * @inheritDoc
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(6),
            'uuid' => (string) $this->faker->unique()->uuid,
            'location' => (new Point($this->faker->latitude(), $this->faker->longitude())),
            'description' =>  $this->faker->text(30),
        ];
    }
}
