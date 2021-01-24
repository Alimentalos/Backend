<?php


namespace Tests\Feature\Stories;


use App\Models\Device;
use App\Models\Group;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewOnGroupDeviceTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanViewOnGroupDevice()
    {
        $user = User::factory()->create();
        $device = Device::factory()->create();
        $device->is_public = false;
        $device->save();
        $user->photo_uuid = Photo::factory()->create()->uuid;
        $group = Group::factory()->create();
        $group->devices()->attach($device->uuid);
        $group->users()->attach($user->uuid);
        $response = $this->actingAs($user, 'api')->json('GET', '/api/devices/' . $device->uuid);
        $response->assertOk();
        $response->assertJsonStructure([
            'user_uuid',
            'location' => [
                'type',
                'coordinates'
            ],
            'uuid',
            'name',
            'description',
            'is_public',
            'created_at',
            'updated_at',
        ]);
        $response->assertJsonFragment([
            'uuid' => $device->uuid,
        ]);
    }
}
