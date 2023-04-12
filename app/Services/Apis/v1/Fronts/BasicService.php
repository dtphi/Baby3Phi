<?php

namespace App\Services\Apis\Fronts;

use App\Contacts\Apis\Fronts\Repositories\Base as BaseRepo;

class BasicService
{
    protected $baseRepo = null;

    public function __construct(BaseRepo $baseRepo)
    {
        $this->baseRepo = $baseRepo;
    }

    public function baseRepository()
    {
        return $this->baseRepo;
    }
}
