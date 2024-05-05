<?php

namespace App\Core\Contracts;

interface SortSecretFriendProvider
{
    public function execute(array $participants): array;
}
