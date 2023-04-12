<?php

namespace App\Http\Controllers\Apis\Admin\Services;

use DB;

trait ScopeService
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
