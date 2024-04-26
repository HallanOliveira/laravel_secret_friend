<?php

namespace App\Core\Services\SecretFriendGroup;

use App\Core\Contracts\Service;
use App\Core\Contracts\Repository;
use App\Core\Contracts\DTO;
use App\Core\DTO\SecretFriendGroup\OutputSecretFriendGroupDTO;

class CreateSecretFriendGroupService implements Service
{
    public function __construct(
        protected DTO        $dto,
        protected Repository $repository
    ) {
    }

    public function execute(): OutputSecretFriendGroupDTO
    {
        $dto = $this->repository->create($this->dto);
        if ($dto instanceof DTO) {
            return $dto;
        }
        throw new \Exception('Erro ao criar grupo de amigo secreto.');
    }
}