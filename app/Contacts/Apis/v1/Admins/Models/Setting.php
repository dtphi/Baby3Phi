<?php

namespace App\Contacts\Apis\Admins\Models;

interface Setting
{
    public static function forceInsert(
        string $code,
        string $key,
        $value = null,
        int $serialized = 1
    );

    public static function forceDeleteByCode(string $code);
}
