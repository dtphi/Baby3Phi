<?php

namespace App\Services\Apis\Fronts\VideoPages;

use App\Contacts\Apis\Fronts\Repositories\Video;

class BasicVideo
{
  public function __construct(
    private Video $videoRepo
  ){
  }

  public function videoRepository()
  {
    return $this->videoRepo;
  }
}
