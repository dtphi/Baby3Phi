<?php

namespace App\Services\Apis\Admins\RestrictIpPages;

use App\Contacts\Apis\Admins\Repositories\RestrictIp;

class BasicRestrictIp
{
  public function __construct(
    private RestrictIp $resIpRepo
  ){
  }

  public function resIpRepository()
  {
    return $this->resIpRepo;
  }
}
