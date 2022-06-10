<?php

namespace App\Repository\Contracts;

interface UserRepositoryInterface
{
    public function getAll(): array;
    public function create(array $data): object;
}
