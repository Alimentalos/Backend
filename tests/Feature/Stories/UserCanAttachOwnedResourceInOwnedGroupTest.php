<?php


namespace Tests\Feature\Stories;


use App\Models\Group;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserCanAttachOwnedResourceInOwnedGroupTest extends TestCase
{
    use RefreshDatabase;

    final public function test_user_can_attach_owned_pet_in_owned_group()
    {
        $user = User::factory()->create();
        $group = Group::factory()->create();

        $resources = ["device", "geofence", "pet"];
        foreach ($resources as $resource) {
            $name = Str::ucfirst($resource);
            $plural = Str::plural($resource);
            $model = resolve("App\\Models\\{$name}");
            $instance = $model::factory()->create();
            change_instance_user($instance, $user);
            change_instance_user($group, $user);
            $group->users()->attach($user, [
                'is_admin' => true,
                'status' => Group::ACCEPTED_STATUS
            ]);

            $response = $this->actingAs($user, 'api')->json(
                'POST',
                "/api/{$plural}/{$instance->uuid}/groups/{$group->uuid}/attach",
                []
            );
            $response->assertOk();
            $this->assertDatabaseHas('groupables', [
                'groupable_type' => "App\\Models\\{$name}",
                'groupable_id' => $instance->uuid,
                'group_uuid' => $group->uuid,
            ]);
        }
    }
}
