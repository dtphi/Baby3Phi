<?php

namespace App\Services\Apis\Admins\InformationCategoryPages;

use App\Contacts\Apis\Admins\Repositories\InformationCategory;

class BasicInformationCategory
{
  public function __construct(
    private InformationCategory $groupInfoRepo
  ){
  }

  public function groupInfoRepository()
  {
    return $this->groupInfoRepo;
  }
}
