<?php

namespace App\Services\Apis\Admins\RestrictIpPages;

use Illuminate\Support\ServiceProvider;

class RestrictIpServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
      $this->app->bind(
        \App\Contacts\Apis\Admins\Repositories\RestrictIp::class,
        \App\Repositories\Apis\Admins\RestrictIpRepository::class
      );
      $this->app->bind('setting', function() {
          return new \App\Services\Apis\Admins\RestrictIpPages\BasicRestrictIp;
      });
    }
}
