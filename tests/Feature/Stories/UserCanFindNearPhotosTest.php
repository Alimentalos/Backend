<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Alert;
use Alimentalos\Relationships\Models\Photo;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanFindNearPhotosTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanFindNearPhotos()
    {
        $user = User::factory()->create();
        $photos = Photo::factory(50)->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/near/photos', [
            'coordinates' => '5.1,5.3'
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'uuid',
                    'location',
                    'user_uuid',
                    'ext',
                    'photo_url',
                    'is_public',
                    'love_reactant_id',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);
    }
}
