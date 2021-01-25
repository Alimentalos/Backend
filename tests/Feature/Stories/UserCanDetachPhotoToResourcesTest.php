<?php


namespace Tests\Feature\Stories;


use App\Models\Comment;
use App\Models\Pet;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserCanDetachPhotoToResourcesTest extends TestCase
{
    use RefreshDatabase;

    final public function test_user_can_detach_photo_to_resources()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $photo = Photo::factory()->create();
        $resources = ["user", "place", "pet", "group", "geofence"];
        foreach ($resources as $resource) {
            $name = Str::ucfirst($resource);
            $photo->user_uuid = $user->uuid;
            $photo->save();
            $model = resolve("App\\Models\\{$name}");
            $plural = Str::plural($resource);
            $instance = $model::factory()->create();
            $instance->user_uuid = $user->uuid;
            $instance->save();
            $instance->photos()->attach($photo->uuid);
            $user->photos()->attach($photo->uuid);
            $response = $this->actingAs($user, 'api')->json('POST', "/api/{$plural}/{$instance->uuid}/photos/{$photo->uuid}/detach");
            $response->assertOk();
            $response->assertExactJson(['message' => 'Resource detached to photo successfully']);
            $this->assertDeleted('photoables', [
                'photoable_type' => "App\\Models\\{$name}",
                'photoable_id' => $instance->uuid,
                'photo_uuid' => $photo->uuid,
            ]);
        }
    }
}
