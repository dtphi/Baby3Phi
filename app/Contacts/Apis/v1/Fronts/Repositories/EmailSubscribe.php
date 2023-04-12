<?php

namespace App\Contacts\Apis\Fronts\Repositories;

interface EmailSubscribe
{
    public function apiInsert(array $data = []);
}
