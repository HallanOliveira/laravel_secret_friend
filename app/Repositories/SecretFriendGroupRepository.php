<?php

namespace App\Repositories;

use App\Core\Contracts\Repository;

class SecretFriendGroupRepository implements Repository
{
    public function create(object $payload): bool
    {
        return true;
    }

    public function update(int $id, object $payload): bool
    {
        return true;
    }

    public function view(int $id): bool
    {
        return true;
    }

    public function delete(int $id): bool
    {
        return true;
    }
}