<?php


namespace Tests\Feature\Stories;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuestCanViewResetPasswordFormTest extends TestCase
{
    use RefreshDatabase;

    public function GuestCanViewResetPasswordFormTest()
    {
        $response = $this->get('/password/reset');
        $response->assertOk();
    }
}
