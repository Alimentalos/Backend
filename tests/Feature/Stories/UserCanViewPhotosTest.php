<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Comment;
use Alimentalos\Relationships\Models\Photo;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewPhotosTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanViewPhotos()
    {
        $user = User::factory()->create();
        $photo = Photo::factory()->create();
        $photo->user_uuid = $user->uuid;

        $user->photo_uuid = $photo->uuid;
        $user->save();
        $photo->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/photos/' . $photo->uuid);
        $response->assertOk();
        $response->assertJsonStructure([
            'location' =>[
                'type',
                'coordinates',
            ],
            'uuid',
            'user_uuid',
            'ext',
            'photo_url',
            'is_public',
            'created_at',
            'updated_at',
            'love_reactant_id',
        ]);
        $response->assertJsonFragment([
            'uuid' => $photo->uuid
        ]);
    }
}
