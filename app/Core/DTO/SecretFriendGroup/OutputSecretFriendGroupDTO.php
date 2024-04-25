<?php

namespace App\Core\DTO\SecretFriendGroup;

use App\Core\Contracts\DTO;

class OutputSecretFriendGroupDTO implements DTO
{
    public readonly int    $id;
    public readonly string $name;
    public readonly string $reveal_date;
    public readonly int    $owner_id;
    public readonly string $created_at;
    public readonly int    $created_by;


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