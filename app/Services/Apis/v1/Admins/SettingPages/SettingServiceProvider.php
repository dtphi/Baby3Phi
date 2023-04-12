<?php

namespace App\Services\Apis\Admins\SettingPages;

use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
      $this->app->bind(
        \App\Contacts\Apis\Admins\Repositories\Setting::class,
        \App\Repositories\Apis\Admins\SettingRepository::class
      );
      $this->app->bind('setting', function() {
          return new \App\Services\Apis\Admins\SettingPages\BasicSetting;
      });
    }
}
