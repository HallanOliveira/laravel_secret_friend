<?php

namespace App\Core\Services\SecretFriendGroup;

use App\Core\Contracts\Service;
use App\Core\Contracts\Repository;
use App\Core\DTO\SecretFriendGroup\CreateSecretFriendGroupDTO;

class CreateSecretFriendGroupService implements Service
{
    public function __construct(
        protected CreateSecretFriendGroupDTO $secretFriendGroupDTO,
        protected Repository                 $repository
    ) {
    }

    public function execute(): bool
    {
        return $this->repository->create($this->secretFriendGroupDTO);
    }
}