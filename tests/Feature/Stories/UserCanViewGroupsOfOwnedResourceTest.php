<?php


namespace Tests\Feature\Stories;


use App\Models\Device;
use App\Models\Group;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserCanViewGroupsOfOwnedResourceTest extends TestCase
{
    use RefreshDatabase;

    final public function test_user_can_view_groups_of_owned_resource()
    {
        $user = User::factory()->create();
        $resources = ["device", "geofence", "pet"];
        foreach ($resources as $resource)
        {
            $name = Str::ucfirst($resource);
            $model = resolve("App\\Models\\{$name}");
            $plural = Str::plural($resource);
            $instance = $model::factory()->create();
            $group = Group::factory()->create();
            $group->user_uuid = $user->uuid;
            $group->photo_uuid = Photo::factory()->create()->uuid;
            $group->save();
            $group->users()->attach($user, [
                'is_admin' => true,
                'status' => Group::ACCEPTED_STATUS
            ]);
            $instance->user_uuid = $user->uuid;
            $instance->save();
            $instance->groups()->attach($group, [
                'status' => Group::ACCEPTED_STATUS
            ]);
            $this->assertDatabaseHas('groupables', [
                'groupable_type' => "App\\Models\\{$name}",
                'groupable_id' => $instance->uuid,
                'group_uuid' => $group->uuid,
            ]);
            $response = $this->actingAs($user, 'api')->json(
                'GET',
                "/api/{$plural}/{$instance->uuid}/groups",
                []
            );
            $response->assertOk();
            $response->assertJsonStructure([
                'data' => [
                    [
                        'uuid',
                        'user',
                        'photo',
                        'description',
                        'is_public'
                    ]
                ]
            ]);
            $response->assertJsonFragment([
                'group_uuid' => $group->uuid,
            ]);
            $response->assertJsonFragment([
                'photo_uuid' => json_decode($response->getContent())->data[0]->photo->uuid,
            ]);
            $response->assertJsonStructure(array_merge(default_pagination_fields(), [
                'data' => [[
                    'uuid',
                    'user_uuid',
                    'photo_uuid',
                    'name',
                    'description',
                    'is_public',
                    'photo_url',
                    'created_at',
                    'updated_at',
                    'pivot' => [
                        'groupable_id',
                        'group_uuid',
                        'groupable_type',
                        'is_admin',
                        'status',
                        'sender_uuid',
                        'created_at',
                        'updated_at'
                    ],
                ]],
            ]));
        }
    }
}
