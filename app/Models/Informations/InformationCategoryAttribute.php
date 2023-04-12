<?php

namespace App\Models\Informations;

trait InformationCategoryAttribute
{
    public function getDisplaysAttribute($value)
    {
        if ($value) {
            return unserialize($value);
        }

        return array('home_page' => false, 'news_page' => false);
    }
}
