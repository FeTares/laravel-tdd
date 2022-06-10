<?php

namespace Tests\Feature\App\Repository\Eloquent;

use App\Models\User;
use App\Repository\Contracts\UserRepositoryInterface;
use App\Repository\Eloquent\UserRepository;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    protected $repository;

    protected function setUp(): void
    {
        $this->repository = new UserRepository(new User());

        parent::setUp();
    }

    public function test_implements_interface()
    {
        $this->assertInstanceOf(
            UserRepositoryInterface::class,
            $this->repository
        );
    }

    public function test_get_all_empty()
    {
        $response = $this->repository->getAll();

        $this->assertIsArray($response);
        $this->assertCount(0, $response);
    }

    public function test_get_all()
    {
        User::factory()->count(10)->create();

        $response = $this->repository->getAll();

        $this->assertIsArray($response);
        $this->assertCount(10, $response);
    }

    public function test_create()
    {
        $data = [
            'name' => 'Felipe Tavares',
            'email' => 'felipe@gg.com',
            'password' => bcrypt('12345678')
        ];

        $response = $this->repository->create($data);

        $this->assertNotNull($response);
        $this->assertIsObject($response);
        $this->assertDatabaseHas('users', [
            'email' => 'felipe@gg.com'
        ]);
    }

    public function test_create_exception()
    {
        $this->expectException(QueryException::class);

        $data = [
            'name' => 'Felipe Tavares',
            'password' => bcrypt('12345678')
        ];

        $this->repository->create($data);
    }

    public function test_update()
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'New Name',
        ];

        $response = $this->repository->update($user->email, $data);

        $this->assertNotNull($response);
        $this->assertIsObject($response);
        $this->assertDatabaseHas('users', [
            'name' => 'New Name'
        ]);
    }
}
