<?php


namespace Tests\Feature\Stories;


use App\Models\Photo;
use App\Models\Place;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserCanViewPhotosOfResourceTest extends TestCase
{
    use RefreshDatabase;

    final public function test_user_can_view_photos_of_resource()
    {
        $user = User::factory()->create();
        $resources = ["group", "pet", "geofence", "place"];

        foreach ($resources as $resource)
        {
            $model = resolve("App\\Models\\" . Str::ucfirst($resource));
            $plural = Str::plural($resource);
            $instance = $model::factory()->create();
            $photo = Photo::factory()->create();
            $photo->{$plural}()->attach($instance->uuid);
            $photo->save();
            $response = $this->actingAs($user, 'api')->json('GET', "/api/{$plural}/{$instance->uuid}/photos");
            $response->assertOk();
            $response->assertJsonStructure(array_merge(default_pagination_fields(), [
                'data' => [
                    [
                        'uuid',
                        'user_uuid',
                        'uuid',
                        'ext',
                        'user',
                        'comment',
                        'is_public',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]));
            $response->assertJsonFragment([
                'photoable_id' => $instance->uuid
            ]);
        }
    }

}
