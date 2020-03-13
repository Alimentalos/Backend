<?php


namespace Tests\Feature\Stories;


use App\Pet;
use App\Place;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanViewPlacesTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanCreatePlaces()
    {
        Storage::fake('public');
        $user = factory(User::class)->create();
        $place = factory(Place::class)->create();
        $place->is_public = true;
        $place->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/places/' . $place->uuid);
        $response->assertOk();
        $response->assertJsonStructure([
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
        ]);
    }
}
