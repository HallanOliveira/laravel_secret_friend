<?php

namespace App\Core\Contracts;

interface DBTransactionProvider {

    public static function begin();

    public static function commit();

    public static function rollBack();

}
