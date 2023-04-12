<?php

namespace App\Models\Informations;

trait InformationToDownloadAttribute
{
    public function getDownloadIdAttribute($value)
    {
        return $value;
    }
}
