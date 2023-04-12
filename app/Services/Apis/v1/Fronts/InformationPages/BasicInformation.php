<?php

namespace App\Services\Apis\Fronts\InformationPages;

use App\Contacts\Apis\Fronts\Repositories\News;

class BasicInformation
{
  public function __construct(
    private News $infoRepo
  ){
  }

  public function informationRepository()
  {
    return $this->infoRepo;
  }
}
