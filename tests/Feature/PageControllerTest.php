<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PageControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_store_method_creates_page()
    {
        $response = $this->post('/api/pages', [
            'user_id' => 'f9f16013-4508-4db4-86bf-220e45741f8a',
            'title' => 'temp',
            'type' => 'hi',
            // Add other required fields here
        ]);

        $response->assertStatus(200); // Assuming you except a 200 OK response
        $this->assertDatabaseHas('pages', ['title' => 'temp', 'type' => 'hi']);
    }
}
