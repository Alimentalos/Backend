<?php

namespace Database\Factories;

use Alimentalos\Relationships\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupFactory extends Factory {

    protected $model = Group::class;

    /**
     * @inheritDoc
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(6),
            'uuid' => (string) $this->faker->unique()->uuid,
            'is_public' => true,
        ];
    }
}
