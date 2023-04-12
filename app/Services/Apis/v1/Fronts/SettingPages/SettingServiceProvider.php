<?php

namespace App\Services\Apis\Fronts\SettingPages;

use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
      $this->app->bind(
        \App\Contacts\Apis\Fronts\Repositories\Setting::class,
        \App\Repositories\Apis\Fronts\SettingRepository::class
      );
      $this->app->bind('setting', function() {
          return new \App\Services\Apis\Fronts\SettingPages\BasicSetting;
      });
    }
}
