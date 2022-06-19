<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repository\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $response = $this->repository->paginate();

        return UserResource::collection(collect($response->items()))
            ->additional([
                'meta' => [
                    'total' => $response->total(),
                    'current_page' => $response->currentPage(),
                    'first_page' => $response->firstPage(),
                    'last_page' => $response->lastPage(),
                    'per_page' => $response->perPage()
                ]
            ]);
    }
}
