<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

if (B3P_INSTALLING) {
  Route::namespace('App\Http\Controllers\Apis\Front')
    ////->middleware('web')
    ->group(function () {
      Route::any('/app/get-setting', 'HomeController@getSetting');
      Route::apiResource('/homes/get-list', 'HomeController');
      Route::get('/app/info/get-information-list', 'NewsController@list');
      Route::get('/app/info/get-information', 'NewsController@detail');
      Route::get('/app/info/get-latest-information', 'NewsController@showLastedList');
      Route::get('/app/info/get-popular-information', 'NewsController@showPopularList');
      Route::get('/app/info/get-related-information', 'NewsController@showRelatedList');
      Route::get('/app/info/get-special-information', 'NewsController@showSpecialModuleList');
      Route::get('/app/get-data-module', 'ModuleController@showDataList');
      Route::get('/app/get-data-giao-xu', 'HomeController@getGiaoXuList');
      Route::get('/app/get-data-giao-phan', 'HomeController@getGiaoPhanList');
      Route::post('/app/get-data-giao-hat', 'HomeController@getGiaoHatList');
      Route::post('/app/get-data-giao-xu-by-id', 'HomeController@getGiaoXuListById');
      Route::get('/app/get-data-giao-xu/{id}', 'HomeController@getGiaoXuDetail');
      Route::get('/app/get-data-linh-muc', 'HomeController@getLinhMucList');
      Route::get('/app/get-data-chuc-vu', 'HomeController@getChucVuList');
      Route::post('/app/get-data-linh-muc-by-id', 'HomeController@getLinhMucListById');
      Route::get('/app/get-detail-linh-muc/{id}', 'HomeController@getLinhMucDetail');
      Route::apiResource('/email_sub/create', 'EmailController');
    });

  Route::namespace('App\Http\Controllers\Apis\Admin')
    //->middleware(['web', 'secip'])
    ->group(function () {
      Route::post('login', 'AuthController@login');
      Route::post('logout', 'AuthController@logout');
    });

  Route::namespace('App\Http\Controllers\Apis\Admin')
    //->middleware(['app.version', 'auth:sanctum', 'secip'])
    ->group(function () {
      Route::get('/user', function (Request $request) {
        $user = $request->user();
        $user->isAdmin = fn_is_admin_permission();
        return $request->user();
      });
    });

  Route::namespace('App\Http\Controllers\Apis\Admin')
    //->middleware(['auth:sanctum', 'secip'])
    ->group(b3p_api_resource_route());
}
