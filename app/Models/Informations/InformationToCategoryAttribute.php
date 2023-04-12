<?php

namespace App\Models\Informations;

trait InformationToCategoryAttribute
{
    public function getCategoryIdAttribute($value)
    {
        return $value;
    }
}
