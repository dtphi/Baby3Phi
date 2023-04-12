<?php

namespace App\Models\Categories;

trait CategoryAttribute
{
    /**
     * @author : dtphi .
     * @param $value
     * @return array|mixed
     */
    public function getDisplaysAttribute($value)
    {
        if ($value) {
            return unserialize($value);
        }

        return array('home_page' => false, 'news_page' => false);
    }
}
