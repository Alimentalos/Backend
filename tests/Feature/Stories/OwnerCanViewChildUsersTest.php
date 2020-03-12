<?php


namespace Tests\Feature\Stories;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OwnerCanViewChildUsersTest extends TestCase
{
    use RefreshDatabase;

    final public function OwnerCanViewChildUsersTest()
    {
        $user = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $user->user_uuid = $userB->uuid;
        $user->save();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/users');
        $response->assertOk();
        $response -> assertJsonStructure([
            'current_page',
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total',
            'data' => [
                [
                    'uuid',
                    'user_uuid',
                    'photo_uuid',
                    'name',
                    'email',
                    'email_verified_at',
                    'free',
                    'photo_url',
                    'location'=>[
                        'type',
                        'coordinates'
                    ],
                    'is_public',
                    'created_at',
                    'updated_at',
                    'love_reactant_id',
                    'love_reacter_id',
                    'is_admin',
                    'is_child',
                    'user',
                    'photo',
                ]
            ],
        ]);
        $response->assertJsonFragment([
            'uuid' => $user->uuid,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }
}
