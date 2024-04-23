<?php

namespace App\Core\DTO\SecretFriendGroup;

class CreateSecretFriendGroupDTO
{
    public readonly string $name;
    public readonly string $reveal_date;
    public readonly string $owner_id;

    public function __construct(array $payload)
    {
        $this->name        = $payload['name'];
        $this->reveal_date = $payload['reveal_date'];
        $this->owner_id    = $payload['owner_id'];
    }
}