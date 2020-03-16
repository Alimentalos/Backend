<?php


namespace Tests\Feature\Stories;


use Demency\Relationships\Models\Photo;
use Demency\Relationships\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewPhotoListTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanViewPhotoList()
    {
        $user = factory(User::class)->create();
        $photo = factory(Photo::class)->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/photos/');
        $response->assertOk();

    }
}
