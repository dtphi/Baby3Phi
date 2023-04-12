<?php

namespace App\Services\Apis\Fronts\VideoPages;

use Illuminate\Support\ServiceProvider;

class VideoServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
      $this->app->bind(
        \App\Contacts\Apis\Fronts\Repositories\Video::class,
        \App\Repositories\Apis\Fronts\VideoRepository::class
      );
      $this->app->bind('video', function() {
          return new \App\Services\Apis\Fronts\VideoPages\BasicVideo;
      });
    }
}
