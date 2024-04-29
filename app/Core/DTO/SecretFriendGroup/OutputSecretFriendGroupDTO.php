<?php

namespace App\Core\DTO\SecretFriendGroup;

use App\Core\Contracts\DTO;
use App\Core\DTO\User\UserDTO;

class OutputSecretFriendGroupDTO implements DTO
{
    public readonly int     $id;
    public readonly string  $name;
    public readonly string  $reveal_date;
    public readonly int     $owner_id;
    public readonly UserDTO $owner;
    public readonly string  $created_at;
    public readonly int     $created_by;
    public readonly array   $participants; # array of ParticipantDTO

    public static function create(array $values): self
    {
        $dto = new self();
        foreach ($values as $key => $value) {
            if (property_exists($dto, $key)) {
                $dto->$key = $value;
            }
        }

        return $dto;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}