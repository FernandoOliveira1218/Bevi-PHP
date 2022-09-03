<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_autenticacao_funcionando()
    {
        $response = $this->get('/api/post');

        $response->assertStatus(401);
    }

    public function test_sem_autenticacao()
    {
        $this->withoutMiddleware();

        $response = $this->get('/api/post');

        $response->assertStatus(200);
    }
}
