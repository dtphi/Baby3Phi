<?php

namespace App\Services\Apis\Admins\GroupAlbumPages;

use Illuminate\Support\ServiceProvider;

class GroupAlbumServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
      $this->app->bind(
        \App\Contacts\Apis\Admins\Repositories\GroupAlbums::class,
        \App\Repositories\Apis\Admins\GroupAlbumsRepository::class
      );
      $this->app->bind('groupAlbum', function() {
          return new \App\Services\Apis\Admins\GroupAlbumPages\BasicGroupAlbum;
      });
    }
}
