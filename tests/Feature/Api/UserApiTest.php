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

    /**
     * @dataProvider dataProviderPagination
     */
    public function test_paginate(
        int $total,
        int $page = 1,
        int $totalPage = 15
    ) {
        User::factory()->count($total)->create();

        $response = $this->getJson("{$this->endpoint}?page={$page}");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount($totalPage, 'data');
        $response->assertJsonStructure([
            'meta' => [
                'total',
                'current_page',
                'first_page',
                'last_page',
                'per_page'
            ],
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email'
                ]
            ]
        ]);
        $response->assertJsonFragment([
            'total' => $total,
            'current_page' => $page
        ]);
    }

    public function dataProviderPagination(): array
    {
        return [
            'test paginate empty' => [ 0, 1, 0 ],
            'test total 15 users page one' => [ 15 ],
            [ 40, 2 ],
            [ 'total' => 40, 'page' => 3, 'totalPage' => 10 ]
        ];
    }

    /**
     * @dataProvider dataProviderCreateUser
     */
    public function test_create(
        array $payload,
        int $statusCode,
        array $structureResponse
    ) {
        $response = $this->postJson($this->endpoint, $payload);
        $response->assertStatus($statusCode);
        $response->assertJsonStructure($structureResponse);
    }

    public function dataProviderCreateUser(): array
    {
        return [
            'test created' => [
                'payload' => [
                    'name' => 'Felipe',
                    'email' => 'felipe@gg.com',
                    'password' => '12345678',
                ],
                'statusCode' => Response::HTTP_CREATED,
                'structureResponse' => [
                    'data' => [
                        'id',
                        'name',
                        'email'
                    ]
                ]
            ],
            'test validation' => [
                'payload' => [],
                'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'structureResponse' => [
                    'errors' => [
                        'name'
                    ]
                ]
            ]
        ];
    }

    public function test_find()
    {
        $user = User::factory()->create();

        $response = $this->getJson("{$this->endpoint}/{$user->email}");
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email'
            ]
        ]);
    }
}
