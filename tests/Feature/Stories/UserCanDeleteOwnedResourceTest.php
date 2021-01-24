<?php


namespace Tests\Feature\Stories;

use Alimentalos\Relationships\Models\Alert;
use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanDeleteOwnedResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_delete_owned_resource()
    {
        $user = User::factory()->create();
        foreach (config('resources.removable') as $key => $removable) {

            if ($key === 'actions')
                continue;

            $instance = (new $removable)::factory()->create();

            if ($key === 'groups') {
                $user->groups()->attach($instance, [
                    'is_admin' => true,
                    'status' => Group::ACCEPTED_STATUS
                ]);
            }

            change_instance_user($instance, $user);

            $this->actingAs($user, 'api')
                 ->json('DELETE', "/api/{$key}/" . $instance->uuid)
                 ->assertOk()
                 ->assertJsonStructure(['message'])
                 ->assertJsonFragment(['message' => 'Resource deleted successfully']);

            $this->assertDeleted($key, [
                'uuid' => $instance->uuid,
            ]);
        }
    }
}
