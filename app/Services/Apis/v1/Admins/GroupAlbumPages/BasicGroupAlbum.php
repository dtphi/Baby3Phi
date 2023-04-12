<?php

namespace App\Services\Apis\Admins\GroupAlbumPages;

use App\Contacts\Apis\Admins\Repositories\GroupAlbums;

class BasicGroupAlbum
{
  public function __construct(
    private GroupAlbums $groupAlbumRepo
  ){
  }

  public function groupAlbumRepository()
  {
    return $this->groupAlbumRepo;
  }
}
