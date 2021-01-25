<?php


namespace Tests\Feature\Stories;


use App\Models\Comment;
use App\Models\Group;
use App\Models\Pet;
use App\Models\Photo;
use App\Models\Place;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserCanAttachPhotoToResourceTest extends TestCase
{
    use RefreshDatabase;

    final public function test_user_can_attach_photo_to_resource()
    {
        $user = User::factory()->create();
        $photo = Photo::factory()->create();
        $resources = ["user", "place", "group", "geofence", "pet"];
        foreach ($resources as $resource) {
            $name = Str::ucfirst($resource);
            $plural = Str::plural($resource);
            $model = resolve("App\\Models\\{$name}");
            $instance = $model::factory()->create();
            change_instance_user($photo, $user);
            change_instance_user($instance, $user);
            $response = $this->actingAs($user, 'api')->json('POST', "/api/{$plural}/{$instance->uuid}/photos/{$photo->uuid}/attach");
            $response->assertOk();
            $this->assertDatabaseHas('photoables', [
                'photoable_type' => "App\\Models\\{$name}",
                'photoable_id' => $instance->uuid,
                'photo_uuid' => $photo->uuid,
            ]);
        }
    }
}
