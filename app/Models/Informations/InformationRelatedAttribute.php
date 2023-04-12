<?php

namespace App\Models\Informations;

trait InformationRelatedAttribute
{
    public function getRelatedIdAttribute($value)
    {
        return (int)$value;
    }
}
