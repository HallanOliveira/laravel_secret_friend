<?php

use App\Core\Contracts\DTO;

trait CreateDTOs
{
    public function createDTO(DTO $dtoClass, array $data): object
    {
        $dto = 'App\DTOs\\' . $dtoClass;
        return new $dto($data);
    }
}
