<?php


namespace Tests\Feature\Stories;


use App\Models\Device;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanCreateDevicesWithoutColorsTest extends TestCase
{
    use RefreshDatabase;

    final public function testUserCanCreateDevicesWithoutColors()
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
        ]);
        $response->assertJsonFragment([
            'name' => $device->name,
            'is_public' => true,
        ]);
    }
}
