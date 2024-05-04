<?php

namespace App\Core\Contracts;

interface DBTransaction {

    public static function begin();

    public static function commit();

    public static function rollBack();

}
