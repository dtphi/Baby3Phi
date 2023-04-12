<?php

namespace App\Services\Apis\Fronts\InformationPages;

use Illuminate\Support\ServiceProvider;

class InformationServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
      $this->app->bind(
        \App\Contacts\Apis\Fronts\Repositories\News::class,
        \App\Repositories\Apis\Fronts\NewsRepository::class
      );
      $this->app->bind('information', function() {
          return new \App\Services\Apis\Fronts\InformationPages\BasicInformation;
      });
    }
}
