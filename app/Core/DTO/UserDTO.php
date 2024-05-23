<?php

namespace App\Core\DTO;

use App\Core\Contracts\DTO;

class UserDTO implements DTO
{
    public readonly int    $id;
    public readonly string $name;
    public readonly string $email;

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
