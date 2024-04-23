<?php

namespace App\Core\Contracts;

interface Repository
{
    public function create(object $payload): bool;

    public function update(int $id, object $payload): bool;

    public function view(int $id): bool;

    public function delete(int $id): bool;
}