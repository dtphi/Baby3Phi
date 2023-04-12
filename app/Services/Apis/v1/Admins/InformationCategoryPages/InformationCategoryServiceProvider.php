<?php

namespace App\Services\Apis\Admins\InformationCategoryPages;

use Illuminate\Support\ServiceProvider;

class InformationCategoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
      $this->app->bind(
        \App\Contacts\Apis\Admins\Repositories\InformationCategory::class,
        \App\Repositories\Apis\Admins\InformationCategoryRepository::class
      );
      $this->app->bind('informationGroup', function() {
          return new \App\Services\Apis\Admins\InformationPages\BasicInformationCategory;
      });
    }
}
