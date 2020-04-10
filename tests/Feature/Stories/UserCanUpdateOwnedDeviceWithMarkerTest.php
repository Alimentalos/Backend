<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Device;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanUpdateOwnedDeviceWithMarkerTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanUpdateOwnedDeviceWithMarker()
    {
        Storage::fake('public');
        $user = factory(User::class)->create();
        $device = factory(Device::class)->create();
        $device->user_uuid = $user->uuid;
        $device->save();
        $response = $this->actingAs($user, 'api')->json('PUT', '/api/devices/' . $device->uuid, [
            'marker' => UploadedFile::fake()->image('photo.png'),
            'name' => 'New name',
            'is_public' => false,
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'uuid',
            'user_uuid',
            'uuid',
            'name',
            'description',
            'created_at',
            'updated_at'
        ]);
        $response->assertJsonFragment([
            'uuid' => $device->uuid,
        ]);
    }
}
