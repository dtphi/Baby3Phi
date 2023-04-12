<?php

namespace App\Services\Apis\Admins\AdminPages;

use App\Contacts\Apis\Admins\Repositories\Admin;

class BasicAdminUser
{
  public function __construct(
    private Admin $adminRepo
  ){
  }

  public function adminRepository()
  {
    return $this->adminRepo;
  }
}
