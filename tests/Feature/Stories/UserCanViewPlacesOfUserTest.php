<?php


namespace Tests\Feature\Stories;


use App\Models\Pet;
use App\Models\Place;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanViewPlacesOfUserTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewPlacesOfUser()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $place = Place::factory()->create();
        $place->user_uuid = $user->uuid;
        $place->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/users/' . $user->uuid . '/places');
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
