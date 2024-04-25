<?php

namespace App\Core\Services\SecretFriendGroup;

use App\Core\Contracts\Service;
use App\Core\Contracts\Repository;
use App\Core\Contracts\DTO;
class CreateSecretFriendGroupService implements Service
{
    public function __construct(
        protected DTO        $dto,
        protected Repository $repository
    ) {
    }

    public function execute(): DTO
    {
        $dto = $this->repository->create($this->dto);
        if ($dto instanceof DTO) {
            return $dto;
        }
        throw new \Exception('Erro ao criar grupo de amigo secreto.');
    }
}