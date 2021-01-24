<?php


namespace Tests\Feature\Stories;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdministratorCanViewUsersTest extends TestCase
{
    use RefreshDatabase;

    final public function testAdministratorCanViewUsers()
    {
        $user = create_admin();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/users');
        $response->assertOk();
        $response->assertJsonStructure(
            array_merge(default_pagination_fields(), ['data' => [
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
            ]])
        );
        $response->assertJsonFragment([
            'uuid' => $user->uuid,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }
}
