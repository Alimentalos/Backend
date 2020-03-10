<?php


namespace Tests\Feature\Stories;


use App\Photo;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserCanDestroyOwnedPhotoTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test testUserCanDestroyOwnedPhoto
     */
    public function testUserCanDestroyOwnedPhoto()
    {
        $user = factory(User::class)->create();
        $photo = factory(Photo::class)->create();
        $photo->user_uuid = $user->uuid;
        $photo->save();
        $response = $this->actingAs($user, 'api')->json('DELETE', '/api/photos/' . $photo->uuid);
        $this->assertDeleted('photos', [
            'uuid' => $photo->uuid,
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'message'
        ]);
        $response->assertJsonFragment([
            'message' => 'Resource deleted successfully'
        ]);
    }

}
