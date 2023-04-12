<?php

namespace App\Services\Apis\Admins\AlbumPages;

use Illuminate\Support\ServiceProvider;

class AlbumServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
      $this->app->bind(
        \App\Contacts\Apis\Admins\Repositories\Albums::class,
        \App\Repositories\Apis\Admins\AlbumsRepository::class
      );
      $this->app->bind('album', function() {
          return new \App\Services\Apis\Admins\AlbumPages\BasicAlbum;
      });
    }
}
