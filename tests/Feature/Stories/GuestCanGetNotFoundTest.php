<?php


namespace Tests\Feature\Stories;


use Tests\TestCase;

class GuestCanGetNotFoundTest extends TestCase
{
    /**
     * testGuestCanGetNotFound
     */
    public function testGuestCanGetNotFound()
    {
        $response = $this->get('/about/fakeUrl');
        $response->assertNotFound();
    }
}
