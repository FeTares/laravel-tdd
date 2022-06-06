<?php

namespace Tests\Feature\App\Repository\Eloquent;

use App\Models\User;
use App\Repository\Eloquent\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    public function test_get_all_empty()
    {
        $repository = new UserRepository(new User());
        $response = $repository->getAll();

        $this->assertIsArray($response);
        $this->assertCount(0, $response);
    }

    public function test_get_all()
    {
        User::factory()->count(10)->create();

        $repository = new UserRepository(new User());
        $response = $repository->getAll();

        $this->assertIsArray($response);
        $this->assertCount(10, $response);
    }
}
