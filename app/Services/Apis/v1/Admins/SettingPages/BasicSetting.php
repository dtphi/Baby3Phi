<?php

namespace App\Services\Apis\Admins\SettingPages;

use App\Contacts\Apis\Admins\Repositories\Setting;

class BasicSetting
{
  public function __construct(
    private Setting $settingRepo
  ){
  }

  public function settingRepository()
  {
    return $this->settingRepo;
  }
}
