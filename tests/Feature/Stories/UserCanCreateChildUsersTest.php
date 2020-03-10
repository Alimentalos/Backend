<?php


namespace Tests\Feature\Stories;


use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanCreateChildUsersTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test testUserCanStoreUser
     */
    final public function testUserCanStoreUser()
    {
        Storage::fake('gcs');
        $user = factory(User::class)->create();
        $userB = factory(User::class)->make();
        $latitude = rand(1,5);
        $longitude = rand(4,10);
        $coordinates = $latitude . ',' . $longitude;
        $response = $this->actingAs($user, 'api')->json('POST', '/api/users', [
            'photo' => UploadedFile::fake()->image('photo50.jpg'),
            'name' => $userB->name,
            'email' => $userB->email,
            'password' => $userB->password,
            'password_confirmation' => $userB->password,
            'is_public' => true,
            'coordinates' => $coordinates,
        ]);
        $response->assertJsonStructure([
            'user_uuid',
            'photo_uuid',
            'photo_url',
            'email',
            'name',
            'is_public',
            'location' => [
                'type',
                'coordinates'
            ],
            'uuid',
            'updated_at',
            'created_at',
            'love_reacter_id',
            'love_reactant_id',
            'is_admin',
            'is_child',
            'photo' => [
                'location' => [
                    'type',
                    'coordinates'
                ],
                'uuid',
                'user_uuid',
                'comment_uuid',
                'ext',
                'photo_url',
                'is_public',
                'created_at',
                'updated_at',
                'love_reactant_id',
            ],
            'user' => [
                'uuid',
                'user_uuid',
                'photo_uuid',
                'photo_url',
                'name',
                'email',
                'is_public',
                'location' => [
                    'type',
                    'coordinates'
                ],
                'love_reacter_id',
                'love_reactant_id',
                'updated_at',
                'created_at',
                'is_admin',
                'is_child',
            ]
        ]);
        $response->assertJsonFragment([
            'name' => $userB->name,
            'email' => $userB->email,
            'is_public' => true,
        ]);
        $response->assertJsonFragment([
            'coordinates' => [
                $longitude,
                $latitude,
            ],
        ]);
        $response->assertCreated();
        $content = $response->getContent();
        Storage::disk('gcs')->assertExists('photos/' . (json_decode($content))->photo->photo_url);
    }
}
