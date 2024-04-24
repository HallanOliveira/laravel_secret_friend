<?php

namespace App\Core\Services\SecretFriendGroup;

use App\Core\Contracts\Service;
use App\Core\Contracts\Repository;

class ListSecretFriendGroupService implements Service
{
    public function __construct(
        protected readonly array      $filters,
        protected readonly Repository $repository
    ) {
    }

    public function execute(): array
    {
        return $this->repository->getAll($this->filters);;
    }
}