<?php

namespace App\Core\DTO;

use App\Core\Contracts\DTO;
use App\Core\DTO\UserDTO;


class SecretFriendGroupDTO implements DTO
{
    public readonly int     $id;
    public readonly int     $owner_id;
    public readonly int     $status_id;
    public readonly string  $name;
    public readonly string  $reveal_date;
    public readonly string  $reveal_location;
    public readonly string  $created_at;
    public readonly int     $created_by;
    public readonly UserDTO $owner;
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
