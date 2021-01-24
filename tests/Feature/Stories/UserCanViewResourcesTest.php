<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Alert;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewResourcesTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_resources()
    {
        $user = User::factory()->create();
        foreach (config('resources.listable') as $key => $listable) {
            $instance = (new $listable)::factory()->create();
            $response = $this->actingAs($user, 'api')->json('GET', "/api/{$key}");
            $response->assertOk();
            $response->assertJsonStructure(
                array_merge(default_pagination_fields(), ['data' => [$instance->fields()]])
            );
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
