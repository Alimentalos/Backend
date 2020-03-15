<?php


namespace Tests\Feature\Stories;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuestCanViewAboutDocumentationTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestCanViewAboutProject()
    {
        $response = $this->get('/about/project');
        $response->assertOk();
    }

    public function testGuestCanViewAboutDocumentation()
    {
        $response = $this->get('/about/project/problem-and-solution');
        $response->assertOk();
    }
}
