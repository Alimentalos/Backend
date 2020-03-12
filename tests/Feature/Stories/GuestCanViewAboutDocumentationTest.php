<?php


namespace Tests\Feature\Stories;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuestCanViewAboutDocumentationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * testGuestCanViewAboutDocumentation
     */
    public function testGuestCanViewAboutDocumentation()
    {
        $response = $this->get('/about/documentation');
        $response->assertOk();
    }
}
