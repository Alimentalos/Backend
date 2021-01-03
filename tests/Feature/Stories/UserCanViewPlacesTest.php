<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Pet;
use Alimentalos\Relationships\Models\Place;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanViewPlacesTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanCreatePlaces()
    {
        $user = User::factory()->create();
        $place = Place::factory()->create();
        $place->is_public = true;
        $place->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/places/');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [[
                'uuid',
                'location',
                'user_uuid',
                'photo_uuid',
                'photo_url',
                'is_public',
                'name',
                'description',
                'created_at',
                'updated_at',
                'love_reactant_id',
                'photo',
                'user'
            ]]
        ]);
    }
}
