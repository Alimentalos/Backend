<?php


namespace Tests\Feature\Stories;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuestCannotConfirmPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function GuestCannotConfirmPasswordTest()
    {
        $response = $this->get('/password/confirm');
        $response->assertRedirect('login');
    }
}
