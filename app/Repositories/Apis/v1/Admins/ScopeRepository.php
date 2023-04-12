<?php

namespace App\Repositories\Apis\Admins;

use DB;

trait ScopeRepository
{
    /**
     * @author : dtphi .
     * @param $query
     * @return mixed
     */
    public function scopeOrderByDescById($query)
    {
        return $query->orderByDesc('id');
    }
}
