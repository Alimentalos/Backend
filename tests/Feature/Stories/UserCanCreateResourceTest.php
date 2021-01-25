<?php


namespace Tests\Feature\Stories;


use App\Models\Comment;
use App\Models\Geofence;
use App\Models\Group;
use App\Models\Pet;
use App\Models\Photo;
use App\Models\User;
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
