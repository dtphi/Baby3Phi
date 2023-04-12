<?php

namespace App\Models\Informations;

trait InformationToCategoryScope
{
    public function scopeFilterByInfoId($query, $infoId)
    {
        $query->where($this->table . '.information_id', (int)$infoId);

        return $query;
    }
}
