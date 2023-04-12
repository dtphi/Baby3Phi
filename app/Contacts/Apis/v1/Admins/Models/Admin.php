<?php

namespace App\Contacts\Apis\Admins\Models;

interface Admin
{
    public function createToken(string $name, array $abilities = ['*']): object;

    public function actionCan(string $name, array $ability): object;
}
