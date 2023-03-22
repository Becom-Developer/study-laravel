<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
    public function testStatusCode()
    {
        $res = $this->get('/home');
        $res->assertStatus(200);
    }
    public function testBody()
    {
        $res = $this->get('/home');
        $res->assertSeeText('こんにちは！');
    }
}
