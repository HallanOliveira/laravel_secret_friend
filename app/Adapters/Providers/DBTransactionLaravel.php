<?php

namespace App\Adapters\Providers;

use App\Core\Contracts\DBTransactionProvider;
use Illuminate\Support\Facades\DB;

class DBTransactionLaravel implements DBTransactionProvider
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
