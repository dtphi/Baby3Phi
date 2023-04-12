<?php

namespace App\Models\Informations;

use App\Http\Common\Tables;

trait InformationScope
{
    /**
     * @author : dtphi .
     * @param $query
     * @param string $alias
     * @return mixed
     */
    public function scopeLjoinDescription($query, $alias = '')
    {
        if (empty($alias)) {
            $alias = Tables::tbl_information_descriptions;
        }

        return $query->leftJoin(Tables::tbl_information_descriptions . ' AS ' . $alias, $this->table . '.information_id',
            '=',
            $alias . '.information_id');
    }

    public function scopeOrderByDescDateAvailable($query)
    {
        $query->orderByDesc($this->table . '.date_available');

        return $query;
    }

    public function scopeOrderByDescViewed($query)
    {
        $query->orderByDesc($this->table . '.viewed');

        return $query;
    }
}
