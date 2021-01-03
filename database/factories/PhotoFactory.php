<?php

namespace Database\Factories;

use Alimentalos\Relationships\Models\Photo;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Factories\Factory;

class PhotoFactory extends Factory {

    protected $model = Photo::class;

    /**
     * @inheritDoc
     */
    public function definition()
    {
        return [
            'uuid' => (string) $this->faker->unique()->uuid,
            'ext' => '.png',
            'photo_url' => config('storage.path') . (string) $this->faker->uuid . '.png',
            'location' => (new Point($this->faker->latitude(), $this->faker->longitude())),
            'is_public' => true,
        ];
    }
}
