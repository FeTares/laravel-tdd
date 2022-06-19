<?php

namespace App\Repository\Contracts;

interface UserRepositoryInterface
{
    public function getAll(): array;
    public function paginate(int $page = 1): PaginationInterface;
    public function create(array $data): object;
    public function update(string $email, array $data): object;
    public function delete(string $email): bool;
    public function find(string $email): ?object;
}
