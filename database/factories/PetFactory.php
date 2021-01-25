<?php

namespace Database\Factories;

use App\Models\Pet;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Factories\Factory;

class PetFactory extends Factory {

    protected $model = Pet::class;

    /**
     * @inheritDoc
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(6),
            'uuid' => (string)$this->faker->unique()->uuid,
            'location' => (new Point($this->faker->latitude(), $this->faker->longitude())),
            'description' => $this->faker->uuid,
            'hair_color' => $this->faker->hexColor,
            'left_eye_color' => $this->faker->hexColor,
            'right_eye_color' => $this->faker->hexColor,
            'api_token' => (string)$this->faker->unique()->uuid,
            'size' => $this->faker->randomElement(['xs', 's', 'm', 'l', 'xl']),
            'born_at' => now(),
            'is_public' => true,
        ];
    }
}
