<?php

namespace Database\Factories;

use Alimentalos\Relationships\Models\Geofence;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Illuminate\Database\Eloquent\Factories\Factory;

class GeofenceFactory extends Factory {

    protected $model = Geofence::class;

    /**
     * @inheritDoc
     */
    public function definition()
    {
        return [
            'uuid' => (string) $this->faker->unique()->uuid,
            'name' => $this->faker->name,
            'is_public' => true,
            'shape' => (new Polygon(geofences()->createSamplePolygon())),
        ];
    }
}
