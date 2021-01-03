<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanHandleGroupInvitationsTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanHandleGroupInvitations()
    {
        $user = User::factory()->create();
        $acceptedUser = User::factory()->create();
        $rejectedUser = User::factory()->create();
        $blockedUser = User::factory()->create();
        $group = Group::factory()->create();
        $group->user_uuid = $user->uuid;
        $group->save();
        $group->users()->attach($user, ['is_admin' => true, 'status' => Group::ACCEPTED_STATUS]);
        $acceptedUser->is_public = true;
        $rejectedUser->is_public = true;
        $blockedUser->is_public = true;
        $acceptedUser->save();
        $rejectedUser->save();
        $blockedUser->save();
        // Accepted user case
        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/users/' . $acceptedUser->uuid  . '/groups/' . $group->uuid . '/invite', [
                'is_admin' => true,
            ]);
        $response->assertOk();
        $this->assertDatabaseHas('groupables', [
            'groupable_type' => 'Alimentalos\\Relationships\\Models\\User',
            'groupable_id' => $acceptedUser->uuid,
            'group_uuid' => $group->uuid,
            'status' => Group::PENDING_STATUS
        ]);
        $response = $this->actingAs($acceptedUser, 'api')
            ->json('POST', '/api/users/' . $acceptedUser->uuid . '/groups/' . $group->uuid . '/accept', [
                'is_admin' => true,
            ]);
        $response->assertOk();
        $this->assertDatabaseHas('groupables', [
            'groupable_type' => 'Alimentalos\\Relationships\\Models\\User',
            'groupable_id' => $acceptedUser->uuid,
            'group_uuid' => $group->uuid,
            'status' => Group::ACCEPTED_STATUS
        ]);
        // Rejected user case
        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/users/' . $rejectedUser->uuid . '/groups/' . $group->uuid . '/invite', [
                'is_admin' => true,
            ]);
        $response->assertOk();
        $this->assertDatabaseHas('groupables', [
            'groupable_type' => 'Alimentalos\\Relationships\\Models\\User',
            'groupable_id' => $rejectedUser->uuid,
            'group_uuid' => $group->uuid,
            'status' => Group::PENDING_STATUS
        ]);
        $response = $this->actingAs($rejectedUser, 'api')
            ->json('POST', '/api/users/' . $rejectedUser->uuid . '/groups/' . $group->uuid . '/reject', [
                'is_admin' => true,
            ]);
        $response->assertOk();
        $this->assertDatabaseHas('groupables', [
            'groupable_type' => 'Alimentalos\\Relationships\\Models\\User',
            'groupable_id' => $rejectedUser->uuid,
            'group_uuid' => $group->uuid,
            'status' => Group::REJECTED_STATUS
        ]);
        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/users/' . $rejectedUser->uuid . '/groups/' . $group->uuid . '/invite', [
                'is_admin' => true,
            ]);
        $response->assertOk();
        $response = $this->actingAs($rejectedUser, 'api')
            ->json('POST', '/api/users/' . $rejectedUser->uuid  . '/groups/' . $group->uuid . '/accept', [
                'is_admin' => true,
            ]);
        $response->assertOk();
        $this->assertDatabaseHas('groupables', [
            'groupable_type' => 'Alimentalos\\Relationships\\Models\\User',
            'groupable_id' => $rejectedUser->uuid,
            'group_uuid' => $group->uuid,
            'status' => Group::ACCEPTED_STATUS
        ]);
        // Blocked user case
        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/users/' . $blockedUser->uuid . '/groups/' . $group->uuid . '/invite', [
                'is_admin' => true,
            ]);
        $response->assertOk();
        $this->assertDatabaseHas('groupables', [
            'groupable_type' => 'Alimentalos\\Relationships\\Models\\User',
            'groupable_id' => $blockedUser->uuid,
            'group_uuid' => $group->uuid,
            'status' => Group::PENDING_STATUS
        ]);
        $response = $this->actingAs($blockedUser, 'api')
            ->json('POST', '/api/users/' . $blockedUser->uuid . '/groups/' . $group->uuid . '/block', [
                'is_admin' => true,
            ]);
        $response->assertOk();
        $this->assertDatabaseHas('groupables', [
            'groupable_type' => 'Alimentalos\\Relationships\\Models\\User',
            'groupable_id' => $blockedUser->uuid,
            'group_uuid' => $group->uuid,
            'status' => Group::BLOCKED_STATUS
        ]);
        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/users/' . $blockedUser->uuid . '/groups/' . $group->uuid . '/invite', [
                'is_admin' => true,
            ]);
        $response->assertStatus(403);
    }
}
