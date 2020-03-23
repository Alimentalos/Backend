<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Photo;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewOwnerUsersTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewOwnerUsers()
    {
        $owner = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $userB->user_uuid = $owner->uuid;
        $userB->save();
        $userC = factory(User::class)->create();
        $userC->photo_uuid = factory(Photo::class)->create()->uuid;
        $userC->user_uuid = $owner->uuid;
        $userC->is_public = false;
        $userC->save();
        $response = $this->actingAs($userB, 'api')->json('GET', '/api/users/' . $userC->uuid);
        $response->assertOk();
        $response->assertJsonStructure([
            'photo_url',
            'email',
            'name',
            'is_public',
            'location' => [
                'type',
                'coordinates'
            ],
            'uuid',
            'user_uuid',
            'photo_uuid',
            'updated_at',
            'created_at',
            'love_reacter_id',
            'love_reactant_id',
            'is_admin',
            'is_child'
        ]);
        $response->assertJsonFragment([
            'name' => $userC->name,
            'email' => $userC->email,
        ]);
    }
}
