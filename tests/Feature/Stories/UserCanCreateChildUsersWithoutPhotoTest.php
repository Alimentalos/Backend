<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanCreateChildUsersWithoutPhotoTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanCreateChildUsersWithoutPhoto()
    {
        $user = factory(User::class)->create();
        $userB = factory(User::class)->make();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/users', [
            'name' => $userB->name,
            'email' => $userB->email,
            'password' => $userB->password,
            'password_confirmation' => $userB->password,
            'is_public' => true,
        ]);
        $response->assertCreated();
        $response->assertJsonStructure([
            'user_uuid',
            'email',
            'name',
            'is_public',
            'uuid',
            'updated_at',
            'created_at',
            'love_reacter_id',
            'love_reactant_id',
            'is_admin',
            'is_child',
        ]);
        $response->assertJsonFragment([
            'name' => $userB->name,
            'email' => $userB->email,
            'is_public' => true,
        ]);
    }
}
