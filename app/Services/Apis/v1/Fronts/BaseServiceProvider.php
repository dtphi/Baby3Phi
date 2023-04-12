<?php

namespace App\Services\Apis\Fronts;

use Illuminate\Support\ServiceProvider;

class BaseServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
      $this->app->bind(
        \App\Contacts\Apis\Fronts\Repositories\Base::class,
        \App\Repositories\Apis\Fronts\BaseRepository::class
      );
      $this->app->bind('setting', function() {
          return new \App\Services\Apis\Fronts\BasicService;
      });
    }
}
