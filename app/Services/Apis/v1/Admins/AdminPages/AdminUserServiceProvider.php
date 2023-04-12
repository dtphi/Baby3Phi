<?php

namespace App\Services\Apis\Admins\AdminPages;

use Illuminate\Support\ServiceProvider;

class AdminUserServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
      $this->app->bind(
        \App\Contacts\Apis\Admins\Repositories\Admin::class,
        \App\Repositories\Apis\Admins\AdminRepository::class
      );
      $this->app->bind('adminUser', function() {
          return new \App\Services\Apis\Admins\AdminPages\BasicAdminUser;
      });
    }
}
