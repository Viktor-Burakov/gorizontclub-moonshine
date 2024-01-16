<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PagesResponseTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexPage(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
