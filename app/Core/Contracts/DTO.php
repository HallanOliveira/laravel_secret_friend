<?php

namespace App\Core\Contracts;

interface DTO
{
    public function toArray(): array;

    public static function create(array $values): self;
}