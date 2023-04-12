<?php

namespace App\Contacts\Apis\Admins\Models;

interface PersonalAccessToken
{
    public static function fcDeleteByTokenableId(int $tokenableId = null);
}
