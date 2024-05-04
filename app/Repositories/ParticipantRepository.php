<?php

namespace App\Repositories;

use App\Core\Contracts\Repository;
use App\Models\Participant;

class ParticipantRepository implements Repository
{
    public function __construct(
        protected Participant $model
    ) {
    }

    public function create(array $data): array
    {
        $this->model->fill($data);
        if ($this->model->save()) {
            return $this->model->toArray();
        }
    }

    public static function createMany(array $data): array
    {
        $createds = [];
        foreach($data as $key => $participant) {
            $repository = app(self::class);
            $created    = $repository->create($participant);
            if (empty($created)) {
                $createds[] = false;
                throw new \Exception("Erro ao criar participante #{$key}.");
            }
            $createds[] = $created;
        }
        return $createds;
    }

    public function update(int $id, array $data): array
    {
        // TODO: update records
    }

    public function view(int $id): bool
    {
        // TODO: view record
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
            ->where($filters)
            ->orderBy('id', 'desc')
            ->get();
        return $data->toArray();
    }
}
