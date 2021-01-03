<?php


namespace Tests\Feature\Stories;


use Alimentalos\Relationships\Models\Photo;
use Alimentalos\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewPhotoListTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanViewPhotoList()
    {
        $user = User::factory()->create();
        $photo = Photo::factory()->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/photos/');
        $response->assertOk();

    }
}
