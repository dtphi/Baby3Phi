<?php

namespace App\Models\Categories;

trait CategoryDescriptionAttribute
{
    public function getDescriptionAttribute($value)
    {
        return htmlspecialchars_decode($value);
    }
}
