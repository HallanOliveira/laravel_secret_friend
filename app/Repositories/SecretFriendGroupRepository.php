<?php

namespace App\Repositories;

use App\Core\Contracts\Repository;
use App\Models\SecretFriendGroup;
use App\Core\Contracts\DTO;

class SecretFriendGroupRepository implements Repository
{
    public function __construct(
        protected SecretFriendGroup $model
    ) {
    }

    public function create(DTO $data): bool
    {
        $this->model->fill($data->toArray());
        return $this->model->save();
    }

    public function update(int $id, DTO $data): bool
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

    public function getAll(array $filters): array
    {
        $data = $this->model->all();
        return $data->toArray();
    }
}