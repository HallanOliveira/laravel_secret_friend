<?php

namespace App\Core\DTO\SecretFriendGroup;

use App\Core\Contracts\DTO;

class InputSecretFriendGroupDTO implements DTO
{
    public readonly int    $id;
    public readonly string $name;
    public readonly string $reveal_date;
    public readonly int    $owner_id;

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