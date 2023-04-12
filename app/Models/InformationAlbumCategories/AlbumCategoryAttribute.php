<?php

namespace App\Models\InformationAlbumCategories;

trait AlbumCategoryAttribute
{
    public function getTenGroupAlbumsAttribute($value)
    {
        $value = ($this->groupAlbums) ? $this->groupAlbums->group_name : '';
        return $value;
    }

    public function getImageOriginAttribute($value)
    {
        $imgThumb = $value;
        if (
            isset($this->image_thumb)
            && $this->image_thumb
            && file_exists(public_path('/.tmb' . $this->image_thumb))
        ) {
            $imgThumb = '/.tmb' . $this->image_thumb;
        }

        return [
            'basename'  => "",
            'dirname'   => "",
            'extension' => "",
            'filename'  => "",
            'path'      => $value,
            'size'      => 0,
            'timestamp' => null,
            'type'      => null,
            'thumb'     => $imgThumb
        ];
    }

    public function getNameGroupAlbumsAttribute($value)
    {
        $value = ($this->groupAlbums) ? $this->groupAlbums->group_name : '';

        return $value;
    }

    public function getGroupImagesAttribute($value)
    {
        $value = [];
        if ($this->image) {
            $value = unserialize($this->image);
        }
        return $value;
    }
}
