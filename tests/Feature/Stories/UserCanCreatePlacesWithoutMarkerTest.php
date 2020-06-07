<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Pet;
use Alimentalos\Relationships\Models\Place;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanCreatePlacesWithoutMarkerTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanCreatePlacesWithoutMarker()
    {
        $user = factory(User::class)->create();
        $place = factory(Place::class)->make();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/places', [
            'name' => $place->name,
            'description' => $place->description,
            'coordinates' => '5.5,6.5',
            'is_public' => false,
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
