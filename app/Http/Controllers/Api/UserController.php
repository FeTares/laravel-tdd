<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
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

    public function store(UserStoreRequest $request)
    {
        $user = $this->repository->create($request->all());

        return new UserResource($user);
    }

    public function show($email)
    {
        $user = $this->repository->find($email);

        return new UserResource($user);
    }

    public function update($email, UserUpdateRequest $request)
    {
        $user = $this->repository->update($email, $request->validated());

        return new UserResource($user);
    }

    public function destroy($email)
    {
        $this->repository->delete($email);

        return response()->noContent();
    }
}
