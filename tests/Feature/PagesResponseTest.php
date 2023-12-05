<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PagesResponseTest extends TestCase
{

    public function testAdminIndex(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
