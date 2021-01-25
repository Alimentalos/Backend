<?php

namespace Database\Factories;

use App\Models\Access;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccessFactory extends Factory {

    protected $model = Access::class;

    /**
     * @inheritDoc
     */
    public function definition()
    {
        return [
            'uuid' => (string) $this->faker->unique()->uuid,
            'geofence_uuid' => (string) $this->faker->unique()->uuid,
            'accessible_type' => 'App\\Models\\Pet',
            'accessible_id' => (string) $this->faker->unique()->uuid,
            'first_location_uuid' => (string) $this->faker->unique()->uuid,
            'last_location_uuid' => (string) $this->faker->unique()->uuid,
            'status' => 1,
        ];
    }
}
