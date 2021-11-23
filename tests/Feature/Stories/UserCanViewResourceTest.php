<?php


namespace Tests\Feature\Stories;


use App\Models\Alert;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_resources()
    {
        $user = User::factory()->create();
        foreach (config('resources.viewable') as $key => $viewable) {
            // TODO Fix view location resource
            if ($key === 'locations') { continue; }
            $instance = (new $viewable)::factory()->create();
            $response = $this->actingAs($user, 'api')->json('GET', "/api/{$key}/{$instance->uuid}");
            $response->assertOk();
            $response->assertJsonStructure($instance->fields());
            $fragment = [];
            foreach ($instance->fields() as $field) {
                // Run through the fields and build the fragment array to assert
                if ($field === 'location' || $field === 'user') { continue; }
                $fragment[$field] = $instance->{$field};
            }
            $response->assertJsonFragment($fragment);
        }
    }
}
