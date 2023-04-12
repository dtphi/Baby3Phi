<?php

namespace App\Contacts\Apis\Admins\Repositories;

interface Admin
{
    public function apiPermissionUpdate(array $allows = [], $tokenablId = null);
}
