<?php

namespace App\Core\Contracts;

interface Service
{
    public function execute(): bool;
}