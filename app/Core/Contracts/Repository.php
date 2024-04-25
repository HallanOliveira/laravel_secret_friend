<?php

namespace App\Core\Contracts;

use App\Core\Contracts\DTO;
interface Repository
{
    public function create(DTO $data): DTO;

    public function update(DTO $data): DTO;

    public function view(int $id): bool;

    public function delete(int $id): bool;

    public function getAll(array $filters): array;
}