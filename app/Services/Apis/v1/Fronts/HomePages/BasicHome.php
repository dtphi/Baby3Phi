<?php

namespace App\Services\Apis\Fronts\HomePages;

use App\Contacts\Apis\Fronts\Repositories\Home;

class BasicHome
{
  public function __construct(
    private Home $homeRepo
  ){
  }

  public function homeRepository()
  {
    return $this->homeRepo;
  }
}
