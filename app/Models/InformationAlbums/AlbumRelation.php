<?php

namespace App\Models\InformationAlbums;

use App\Models\GroupAlbums;

trait AlbumRelation
{
    public function groupAlbums()
    {
        return $this->belongsTo(GroupAlbums::class, 'group_albums_id');
    }
}
