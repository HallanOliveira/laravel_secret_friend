<?php

namespace App\Core\DTO;

use App\Core\Contracts\DTO;

class ParticipantDTO implements DTO
{
    public readonly int    $id;
    public readonly string $name;
    public readonly int    $owner_id;
    public readonly string $phone;
    public readonly string $email;
    public readonly string $suggestion;
    public readonly int    $secret_friend_id;
    public readonly int    $secret_friend_group_id;

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
