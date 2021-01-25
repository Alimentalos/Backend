<?php

namespace Database\Factories;

use App\Models\Operation;
use Illuminate\Database\Eloquent\Factories\Factory;

class OperationFactory extends Factory {

    protected $model = Operation::class;

    /**
     * @inheritDoc
     */
    public function definition()
    {
        return [
            'uuid' => (string) $this->faker->unique()->uuid,
            'status' => $this->faker->numberBetween(0, 1),
            'amount' => $this->faker->numberBetween(1, 100000),
        ];
    }
}
