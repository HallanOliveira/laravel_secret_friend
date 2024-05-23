<?php

namespace App\Core\Enums;

enum SecretFriendStatusEnum: int
{
    case Pendente    = 1;
    case Processando = 2;
    case Sorteado    = 3;
    case Erro        = 4;

    public static function values(): array
    {
       return array_column(self::cases(), 'value');
    }
}
