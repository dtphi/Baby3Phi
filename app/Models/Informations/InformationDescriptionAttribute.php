<?php

namespace App\Models\Informations;

trait InformationDescriptionAttribute
{
    public function getNameAttribute($value)
    {
        return htmlspecialchars_decode($value);
    }

    public function getDescriptionAttribute($value)
    {
        return htmlspecialchars_decode($value);
    }

    public function getMetaTitleAttribute($value)
    {

        return $value;
    }

    public function getMetaDescriptionAttribute($value)
    {
        return $value;
    }

    public function getTagAttribute($value)
    {
        return $value;
    }

    public function getMetaKeywordAttribute($value)
    {

        return $value;
    }
}
