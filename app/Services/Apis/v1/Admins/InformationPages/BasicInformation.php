<?php

namespace App\Services\Apis\Admins\InformationPages;

use App\Contacts\Apis\Admins\Repositories\Information;

class BasicInformation
{
  public function __construct(
    private Information $infoRepo
  ){
  }

  public function infoRepository()
  {
    return $this->infoRepo;
  }
}
