<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Device;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanCreateDevicesTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanCreateDevices()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $user->free = true;
        $user->save();
        $device = Device::factory()->make();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/devices', [
            'name' => $device->name,
            'description' => 'Blah blah blah',
            'is_public' => true,
            'color' => '#69BFDB',
            'marker_color' => '#33CCAD',
            'marker' => UploadedFile::fake()->image('dev.jpg'),
        ]);
        $response->assertCreated();
        $response->assertJsonStructure([
            'name',
            'description',
            'user_uuid',
            'is_public',
            'uuid',
            'updated_at',
            'created_at',
            'marker'
        ]);
        $response->assertJsonFragment([
            'name' => $device->name,
            'is_public' => true,
        ]);
    }
}
