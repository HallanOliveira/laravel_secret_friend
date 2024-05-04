<?php

namespace App\Adapters\Providers;

use App\Core\Contracts\DBTransaction;
use Illuminate\Support\Facades\DB;

class DBTransactionProvider implements DBTransaction
{
    public static function begin()
    {
        DB::beginTransaction();
    }

    public static function commit()
    {
        DB::commit();
    }

    public static function rollBack()
    {
        DB::rollBack();
    }
}
