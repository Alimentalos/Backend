<?php

namespace Tests\Feature;

use Tests\TestCase;

class AboutTest extends TestCase
{
    public function test_about_route()
    {
        $response = $this->get('/about');
        $response->assertOk();
    }

    public function test_about_developer_guide_route()
    {
        $response = $this->get('/about/developer-guide');
        $response->assertOk();
    }

    public function test_about_documentation_route()
    {
        $response = $this->get('/about/documentation');
        $response->assertOk();
    }

    public function test_about_404_route()
    {
        $response = $this->get('/about/fakeUrl');
        $response->assertNotFound();
    }
}
