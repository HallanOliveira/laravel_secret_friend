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

    public function execute(): void
    {
        if (! $this->repository->create($this->dto)) {
            throw new \Exception('Ocorreu um erro ao o criar grupo de amigo secreto');
        }
    }
}