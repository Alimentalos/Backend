<?php


namespace Tests\Feature\Stories;


use App\Photo;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserCanViewPhotoListTest extends TestCase
{
    use DatabaseMigrations;

    public function testIndexPhotosApi()
    {
        $user = factory(User::class)->create();
        $photo = factory(Photo::class)->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/photos/');
        $response->assertOk();

    }
}
