<?php

namespace App\Services\Apis\Fronts\EmailSubscribes;

use App\Contacts\Apis\Fronts\Repositories\EmailSubscribe;

class BasicEmailSubscribe
{
  public function __construct(
    private EmailSubscribe $emailRepo
  ){
  }

  public function emailRepository()
  {
    return $this->emailRepo;
  }
}
