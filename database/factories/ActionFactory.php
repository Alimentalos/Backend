<?php

namespace Database\Factories;

use Alimentalos\Relationships\Models\Action;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActionFactory extends Factory {

    protected $model = Action::class;

    /**
     * @inheritDoc
     */
    public function definition()
    {
        return [
            'uuid' => (string) $this->faker->unique()->uuid,
            'resource' => 'Sample',
            'type' => $this->faker->randomElement(['success', 'failed', 'rejected']),
            'parameters' => [
                'some-parameter' => $this->faker->numberBetween(0, 1000),
                'another-parameter' => (string) $this->faker->unique()->uuid,
                'awesome-parameter' => $this->faker->sentence($this->faker->numberBetween(10, 40))
            ],
        ];
    }
}
