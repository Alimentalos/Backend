<?php

namespace Database\Factories;

use Alimentalos\Relationships\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory {

    protected $model = Comment::class;

    /**
     * @inheritDoc
     */
    public function definition()
    {
        return [
            'uuid' => (string) $this->faker->unique()->uuid,
            'title' => $this->faker->sentence($this->faker->numberBetween(5, 8)),
            'body' => $this->faker->sentence($this->faker->numberBetween(40, 100)),
        ];
    }
}
