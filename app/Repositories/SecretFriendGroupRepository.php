<?php

namespace App\Repositories;

use App\Core\Contracts\Repository;
use App\Models\SecretFriendGroup;

class SecretFriendGroupRepository implements Repository
{
    public function __construct(
        protected SecretFriendGroup $model,
    ) {
    }

    public function create(array $data): array
    {
        $data['owner_id'] = auth()->id();
        $this->model->fill($data);
        if ($this->model->save()) {
            return $this->model->toArray();
        }
    }

    public static function createMany(array $data): array
    {
        // TODO: create many records
    }

    public function update(int $id, array $data): array
    {
        $this->model = $this->model->find($id);
        $this->model->fill($data);
        if ($this->model->save()) {
            return $this->model->toArray();
        }

    }

    public function view(int $id): bool
    {
        return $this->model->find($id);
    }

    public function delete(int $id): bool
    {
        return $this
            ->model
            ->find($id)
            ->delete();
    }

    public function getAll(array $filters): array
    {
        $data = $this->model
            ->where('owner_id', auth()->id())
            ->with('participants')
            ->orderBy('id', 'desc')
            ->get();
        return $data->toArray();
    }
}
