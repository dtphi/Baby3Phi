<?php

namespace App\Models\Informations;

use App\Http\Common\Tables;

trait InformationRelatedScope
{
    public function scopeLfJoinInfo($query)
    {
        $query->leftJoin(
            Tables::tbl_informations,
            $this->table . '.related_id',
            '=',
            Tables::tbl_informations . '.information_id'
        );

        return $query;
    }

    public function scopeFilterByInfoId($query, $infoId)
    {
        $query->where($this->table . '.information_id', (int)$infoId);

        return $query;
    }
}
