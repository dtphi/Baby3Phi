<?php

namespace App\Models\InformationAlbumCategories;

use App\Models\Albums;

trait AlbumCategoryRelation
{
    public function albums()
    {
        return $this->hasMany(Albums::class);
    }
}
