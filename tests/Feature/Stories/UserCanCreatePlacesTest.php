<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Pet;
use Alimentalos\Relationships\Models\Place;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanCreatePlacesTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanCreatePlaces()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $place = Place::factory()->make();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/places', [
            'photo' => UploadedFile::fake()->image('photo1.jpg'),
            'marker' => UploadedFile::fake()->image('marker.jpg'),
            'name' => $place->name,
            'description' => $place->description,
            'coordinates' => '5.5,6.5',
            'is_public' => false,
            'color' => '#5AAB17',
            'marker_color' => '#1786AB',
        ]);
        $response->assertCreated();
        $content = $response->getContent();
        $this->assertDatabaseHas('places', [
            'uuid' => (json_decode($content))->uuid,
            'name' => $place->name,
            'description' => $place->description,
        ]);
        Storage::disk('public')->assertExists((json_decode($content))->photo->photo_url);
        $response->assertJsonStructure([
           'photo_url',
           'user_uuid',
           'photo_uuid',
           'location',
           'name',
           'description',
           'uuid',
           'updated_at',
           'created_at',
           'love_reactant_id',
           'photo',
           'user',
        ]);
    }
}
