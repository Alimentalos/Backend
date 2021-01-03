<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Comment;
use Alimentalos\Relationships\Models\Geofence;
use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\Pet;
use Alimentalos\Relationships\Models\Photo;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanCreateResourceTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanCreateResource()
    {
        $user = User::factory()->create();

        // TODO - Implement a way to test all create resource form
        $response = $this->actingAs($user)->get('/pets/create');
        $response->assertOk();
    }
}
