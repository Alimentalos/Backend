<?php

namespace Database\Factories;

use App\Models\Geofence;
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
            'shape' => (create_default_polygon()),
        ];
    }
}
