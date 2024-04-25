<?php

namespace App\Repositories;

use App\Core\Contracts\Repository;
use App\Models\SecretFriendGroup;
use App\Core\Contracts\DTO;
use App\Core\DTO\SecretFriendGroup\OutputSecretFriendGroupDTO;

class SecretFriendGroupRepository implements Repository
{
    public function __construct(
        protected SecretFriendGroup $model
    ) {
    }

    public function create(DTO $data): OutputSecretFriendGroupDTO
    {
        $this->model->fill($data->toArray());
        if ($this->model->save()) {
            return OutputSecretFriendGroupDTO::create($this->model->toArray());
        }
    }

    public function update(DTO $data): OutputSecretFriendGroupDTO
    {
        $this->model = $this->model->find($data->id);
        $this->model->fill($data->toArray());
        if ($this->model->save()) {
            return OutputSecretFriendGroupDTO::create($this->model->toArray());
        }

    }

    public function view(int $id): bool
    {
        return $this->model->find($id);
    }

    public function delete(int $id): bool
    {
        return $this->model->find($id)->delete();
    }

    public function getAll(array $filters): array
    {
        $data = $this->model
            ->where('owner_id', auth()->id())
            ->get();
        return $data->toArray();
    }
}