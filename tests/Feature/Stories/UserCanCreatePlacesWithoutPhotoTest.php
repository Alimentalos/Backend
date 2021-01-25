<?php

namespace Tests\Feature\Stories;

use App\Models\Place;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanCreatePlacesWithoutPhotoTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanCreatePlacesWithoutPhoto()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $place = Place::factory()->make();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/places', [
            'marker' => UploadedFile::fake()->image('marker.jpg'),
            'name' => $place->name,
            'description' => $place->description,
            'coordinates' => '5.5,6.5',
            'is_public' => false,
            'color' => '#136480',
            'marker_color' => '#3AA5C9',
        ]);
        $response->assertCreated();
        $content = $response->getContent();
        $this->assertDatabaseHas('places', [
            'uuid' => (json_decode($content))->uuid,
            'name' => $place->name,
            'description' => $place->description,
        ]);
        $response->assertJsonStructure([
           'user_uuid',
           'location',
           'name',
           'description',
           'uuid',
           'updated_at',
           'created_at',
           'love_reactant_id',
           'user',
        ]);
    }
}
