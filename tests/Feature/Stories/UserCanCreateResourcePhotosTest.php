<?php


namespace Tests\Feature\Stories;


use Demency\Relationships\Models\Comment;
use Demency\Relationships\Models\Geofence;
use Demency\Relationships\Models\Group;
use Demency\Relationships\Models\Pet;
use Demency\Relationships\Models\Photo;
use Demency\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanCreateResourcePhotosTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanCreateResourcePhotos()
    {
        Storage::fake('public');
        $user = factory(User::class)->create();
        $pet = factory(Pet::class)->create();
        $pet->user_uuid = $user->uuid;
        $group = factory(Group::class)->create();
        $group->user_uuid = $user->uuid;
        $group->save();
        $geofence = factory(Geofence::class)->create();
        $geofence->user_uuid = $user->uuid;
        $geofence->save();
        $photo = factory(Photo::class)->create();
        $photo->comment_uuid = factory(Comment::class)->create()->uuid;
        $photo->user_uuid = $user->uuid;
        $user->photo_uuid = $photo->uuid;
        $pet->photo_uuid = $photo->uuid;
        $pet->save();
        $user->save();
        $photo->save();
        $this->assertDatabaseMissing('locations', [
            'trackable_type' => 'Demency\\Relationships\\Models\\User',
            'trackable_id' => $user->uuid,
        ]);

        $response = $this->actingAs($user, 'api')->json('POST', '/api/users/' . $user->uuid . '/photos/', [
            'photo' => UploadedFile::fake()->image('photo50.jpg'),
            'title' => 'New title',
            'is_public' => true,
            'coordinates' => '5.5,6.5',
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'uuid',
            'user_uuid',
            'comment_uuid',
            'ext',
            'photo_url',
            'is_public',
            'location' =>[
                'type',
                'coordinates',
            ],
            'created_at',
            'updated_at',
            'love_reactant_id',
        ]);
        $response->assertJsonFragment([
            'user_uuid' => $user->uuid
        ]);

        $this->assertDatabaseHas('locations', [
            'trackable_type' => 'Demency\\Relationships\\Models\\User',
            'trackable_id' => $user->uuid,
        ]);

        $this->assertDatabaseMissing('locations', [
            'trackable_type' => 'Demency\\Relationships\\Models\\Pet',
            'trackable_id' => $pet->uuid,
        ]);

        Storage::disk('public')->assertExists('photos/' . (json_decode($response->getContent()))->photo_url);
        $response = $this->actingAs($user, 'api')->json('POST', '/api/pets/' . $pet->uuid . '/photos/', [
            'photo' => UploadedFile::fake()->image('photo50.jpg'),
            'title' => 'New title',
            'is_public' => true,
            'coordinates' => '60.1,25.5'
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'uuid',
            'user_uuid',
            'comment_uuid',
            'ext',
            'photo_url',
            'is_public',
            'location' =>[
                'type',
                'coordinates',
            ],
            'created_at',
            'updated_at',
            'love_reactant_id',
        ]);
        $response->assertJsonFragment([
            'user_uuid' => $user->uuid
        ]);

        $this->assertDatabaseHas('locations', [
            'trackable_type' => 'Demency\\Relationships\\Models\\Pet',
            'trackable_id' => $pet->uuid,
        ]);

        Storage::disk('public')->assertExists('photos/' . (json_decode($response->getContent()))->photo_url);
        $response = $this->actingAs($user, 'api')->json('POST', '/api/geofences/' . $geofence->uuid . '/photos/', [
            'photo' => UploadedFile::fake()->image('photo50.jpg'),
            'title' => 'New title',
            'is_public' => true,
            'coordinates' => '60.1,25.5'
        ]);
        $response->assertOk();
        $response->assertOk();
        $response->assertJsonStructure([
            'uuid',
            'user_uuid',
            'comment_uuid',
            'ext',
            'photo_url',
            'is_public',
            'location' =>[
                'type',
                'coordinates',
            ],
            'created_at',
            'updated_at',
            'love_reactant_id',
        ]);
        $response->assertJsonFragment([
            'user_uuid' => $user->uuid
        ]);
        Storage::disk('public')->assertExists('photos/' . (json_decode($response->getContent()))->photo_url);
        $response = $this->actingAs($user, 'api')->json('POST', '/api/groups/' . $group->uuid . '/photos/', [
            'photo' => UploadedFile::fake()->image('photo50.jpg'),
            'title' => 'New title',
            'is_public' => true,
            'coordinates' => '60.1,25.5'
        ]);
        $response->assertOk();
        $response->assertOk();
        $response->assertJsonStructure([
            'uuid',
            'user_uuid',
            'comment_uuid',
            'ext',
            'photo_url',
            'is_public',
            'location' =>[
                'type',
                'coordinates',
            ],
            'created_at',
            'updated_at',
            'love_reactant_id',
        ]);
        $response->assertJsonFragment([
            'user_uuid' => $user->uuid
        ]);
        Storage::disk('public')->assertExists('photos/' . (json_decode($response->getContent()))->photo_url);
    }
}
