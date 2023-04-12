<?php

namespace App\Services\Apis\Admins\InformationPages;

use Illuminate\Support\ServiceProvider;

class InformationServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
      $this->app->bind(
        \App\Contacts\Apis\Admins\Repositories\Information::class,
        \App\Repositories\Apis\Admins\InformationRepository::class
      );
      $this->app->bind('information', function() {
          return new \App\Services\Apis\Admins\InformationPages\BasicInformation;
      });
    }
}
