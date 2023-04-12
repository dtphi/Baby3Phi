<?php

namespace App\Services\Apis\Admins\AlbumPages;

use App\Contacts\Apis\Admins\Repositories\Albums;

class BasicAlbum
{
  public function __construct(
    private Albums $albumRepo
  ){
  }

  public function albumRepository()
  {
    return $this->albumRepo;
  }
}
