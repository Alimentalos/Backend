<?php


namespace Tests\Feature\Stories;


use App\Alert;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCanDeleteOwnedAlertTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanDeleteOwnedAlert()
    {
        Storage::fake('public');
        $user = factory(User::class)->create();
        $alert = factory(Alert::class)->create();
        $alert->user_uuid = $user->uuid;
        $alert->save();
        $response = $this->actingAs($user, 'api')->json('DELETE', '/api/alerts/' . $alert->uuid);
        $response->assertOk();

        $response->assertJsonStructure([
            'message'
        ]);
        $response->assertJsonFragment([
            'message' => 'Resource deleted successfully'
        ]);


        $this->assertDeleted('alerts', [
            'uuid' => $alert->uuid,
        ]);
    }
}
