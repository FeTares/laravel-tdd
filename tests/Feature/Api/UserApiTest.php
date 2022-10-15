<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    protected string $endpoint = '/api/users';

    public function test_paginete_empty()
    {
        $response = $this->getJson($this->endpoint);
        $response->assertOk();
        $response->assertJsonCount(0, 'data');
        $response->assertJsonStructure([
            'meta' => [
                'total',
                'current_page',
                'first_page',
                'last_page',
                'per_page'
            ],
            'data'
        ]);
        $response->assertJsonFragment([ 'total' => 0 ]);
    }

    public function test_paginate()
    {
        User::factory()->count(40)->create();

        $response = $this->getJson($this->endpoint);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(15, 'data');
        $response->assertJsonStructure([
            'meta' => [
                'total',
                'current_page',
                'first_page',
                'last_page',
                'per_page'
            ]
        ]);
        $response->assertJsonFragment([
            'total' => 40,
            'current_page' => 1
        ]);
    }

    public function test_page_two()
    {
        User::factory()->count(20)->create();

        $response = $this->getJson("{$this->endpoint}?page=2");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(5, 'data');
        $response->assertJsonFragment([
            'total' => 20,
            'current_page' => 2
        ]);
    }
}
