<?php

namespace App\Services\Apis\Fronts\HomePages;

use Illuminate\Support\ServiceProvider;

class HomeServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
      $this->app->bind(
        \App\Contacts\Apis\Fronts\Repositories\Home::class,
        \App\Repositories\Apis\Fronts\HomeRepository::class
      );
      $this->app->bind('home', function() {
          return new \App\Services\Apis\Fronts\HomePages\BasicHome;
      });
    }
}
