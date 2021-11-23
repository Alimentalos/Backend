<?php


namespace Tests\Feature\Stories;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserCanFindNearResourcesTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_find_near_resources()
    {
        $user = User::factory()->create();
        $resources = ["alert", "geofence", "pet", "photo", "place", "user"];
        foreach ($resources as $resource) {
            $model = resolve("App\\Models\\" . Str::ucfirst($resource));
            $instances = $model::factory(50)->create();
            $plural = Str::plural($resource);
            $response = $this->actingAs($user, 'api')->json('GET', "/api/near/{$plural}", [
                'coordinates' => '5.1,5.3'
            ]);
            $response->assertOk();
            $response->assertJsonStructure([
                'data' => [
                    [
                        'uuid',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ]);
        }
    }
}
