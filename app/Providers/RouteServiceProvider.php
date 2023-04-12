<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function (Request $request) {
          $cmsAppConfs = config('app.cms.routeServiceProvider');
          $route = Route::namespace($this->namespace);
          if ($request->is('api*')) {
            $route->prefix($cmsAppConfs['api']['prefix'])
              ->middleware($cmsAppConfs['api']['middleware'])
              ->group($cmsAppConfs['api']['groupPath']);

              if ($request->is('api/mmedia*')) {
                $route->group($cmsAppConfs['api']['childs']['api_mmedia']['groupPath']);
              }
          } else {
            if ($request->is('admin*')) {
              $route->middleware($cmsAppConfs['admin']['middleware'])
                ->group($cmsAppConfs['admin']['groupPath']);
            } else {
              $route->middleware($cmsAppConfs['web']['middleware'])
                ->group($cmsAppConfs['web']['groupPath']);
            }
          }
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
