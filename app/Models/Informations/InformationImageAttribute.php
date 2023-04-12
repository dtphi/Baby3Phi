<?php

namespace App\Models\Informations;

trait InformationImageAttribute
{
    public function getImageAttribute($value)
    {
        return $value;
    }

    public function getSortOrderAttribute($value)
    {
        return $value;
    }

    public function getImageOriginAttribute($value)
    {
        $value = ($this->album) ? $this->album->image_origin: '';

        return $value;
    }

    public function getAlbumNameAttribute($value)
    {
        $value = ($this->album) ? $this->album->albums_name: '';

        return $value;
    }

    public function getArrImageListAttribute($value)
    {
        $value = ($this->album) ? $this->album->image : [];

        $value = !empty($value) ? unserialize($value): [];
        if (!empty($value)) {
            $sort = array_column($value, 'width');
            array_multisort($sort, SORT_ASC, $value);
        }

        return $value;
    }
}
