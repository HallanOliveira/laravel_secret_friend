<?php

namespace App\Core\Contracts;

use App\Core\Contracts\DTO;
interface Repository
{
    public function create(array $data): array;

    public function update(int $id, array $data): array;

    public function view(int $id): bool;

    public function delete(int $id): bool;

    public function getAll(array $filters): array;

    public static function createMany(array $data): array;
}