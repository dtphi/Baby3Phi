<?php

namespace App\Services\Apis\Fronts\EmailSubscribes;

use Illuminate\Support\ServiceProvider;

class EmailSubscribeServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
      $this->app->bind(
        \App\Contacts\Apis\Fronts\Repositories\EmailSubscribe::class,
        \App\Repositories\Apis\Fronts\EmailSubscribeRepository::class
      );
      $this->app->bind('emailSubscribe', function() {
          return new \App\Services\Apis\Fronts\EmailSubscribes\BasicEmailSubscribe;
      });
    }
}
