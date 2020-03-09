<?php

namespace Tests\Feature\Api;

use App\Action;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class PassportTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test testAdministratorUserCanDeleteAction
     */
    final public function testAdministratorUserCanDeleteAction()
    {
        $exit = $this->artisan('passport:client --password --no-interaction')->assertExitCode(0);
        dd($exit);

        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json('GET', '/token', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        dd($response->getContent());


        $response->assertCreated();
        $secret = json_decode($response->getContent())->secret;
        $id = json_decode($response->getContent())->id;

        $response = $this->actingAs($user, 'api')->json('GET', '/oauth/clients/' . $id);
        $response = $this->actingAs($user, 'api')->json('GET', '/callback', [
            ''
        ]);
        dd($response->getContent());
    }
}
