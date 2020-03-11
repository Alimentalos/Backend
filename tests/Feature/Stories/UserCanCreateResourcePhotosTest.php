<?php


namespace Tests\Feature\Stories;


use App\Comment;
use App\Geofence;
use App\Group;
use App\Pet;
use App\Photo;
use App\User;
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

        // User

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
            'uuid' => $user->uuid
        ]);
        Storage::disk('public')->assertExists('photos/' . (json_decode($response->getContent()))->photo_url);


        // Pet

        $response = $this->actingAs($user, 'api')->json('POST', '/api/pets/' . $pet->uuid . '/photos/', [
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
            'user' =>[
                'uuid',
                'user_uuid',
                'photo_uuid',
                'name',
                'email',
                'email_verified_at',
                'free',
                'photo_url',
                'location' =>[
                    'type',
                    'coordinates',
                ],
                'is_public',
                'created_at',
                'updated_at',
                'love_reactant_id',
                'love_reacter_id',
                'is_admin',
                'is_child',
            ],
            'comment' => [
                'uuid',
                'user_uuid',
                'title',
                'body',
                'commentable_type',
                'commentable_id',
                'created_at',
                'updated_at',
                'love_reactant_id'
            ],
        ]);
        $response->assertJsonFragment([
            'uuid' => $user->uuid
        ]);

        Storage::disk('public')->assertExists('photos/' . (json_decode($response->getContent()))->photo_url);

        // Geofence

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
            'user' =>[
                'uuid',
                'user_uuid',
                'photo_uuid',
                'name',
                'email',
                'email_verified_at',
                'free',
                'photo_url',
                'location' =>[
                    'type',
                    'coordinates',
                ],
                'is_public',
                'created_at',
                'updated_at',
                'love_reactant_id',
                'love_reacter_id',
                'is_admin',
                'is_child',
            ],
            'comment' => [
                'uuid',
                'user_uuid',
                'title',
                'body',
                'commentable_type',
                'commentable_id',
                'created_at',
                'updated_at',
                'love_reactant_id'
            ],
        ]);
        $response->assertJsonFragment([
            'uuid' => $user->uuid
        ]);
        Storage::disk('public')->assertExists('photos/' . (json_decode($response->getContent()))->photo_url);

        // Group

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
            'user' =>[
                'uuid',
                'user_uuid',
                'photo_uuid',
                'name',
                'email',
                'email_verified_at',
                'free',
                'photo_url',
                'location' =>[
                    'type',
                    'coordinates',
                ],
                'is_public',
                'created_at',
                'updated_at',
                'love_reactant_id',
                'love_reacter_id',
                'is_admin',
                'is_child',
            ],
            'comment' => [
                'uuid',
                'user_uuid',
                'title',
                'body',
                'commentable_type',
                'commentable_id',
                'created_at',
                'updated_at',
                'love_reactant_id'
            ],
        ]);
        $response->assertJsonFragment([
            'uuid' => $user->uuid
        ]);
        Storage::disk('public')->assertExists('photos/' . (json_decode($response->getContent()))->photo_url);
    }
}
