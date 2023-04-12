<?php

namespace App\Services\Apis\Fronts\SettingPages;

use App\Contacts\Apis\Fronts\Repositories\Setting;

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
