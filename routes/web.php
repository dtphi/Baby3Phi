<?php

use Illuminate\Support\Facades\Route;
use App\AppGlobals\Front;
use App\ViewDatas\Fronts\HomeData;
use App\ViewDatas\Statics\CartData;
use App\ViewDatas\Statics\Products\DetailData;
use App\ViewDatas\Statics\ProductData;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
| Comment when Init project , generate key .
| // Route::view('/{any}', 'welcome', ['data' => new Front()],200, Front::getHeaderScript())->where('any', '.*');
*/
class template {
  public function __construct()
  {

  }

  public function view() {
    return 'b3p-home';
  }
}
if (B3P_INSTALLING) {
  Route::view('/', (new template())->view(), ['data' => new HomeData()],200, Front::getHeaderScript());
  Route::view('/product', 'statics/product/index', ['data' => new ProductData()],200, Front::getHeaderScript());
  Route::view('/product/{any}', 'statics/product/index', ['data' => new DetailData()],200, Front::getHeaderScript());
  Route::view('/cart', 'statics/cart/index', ['data' => new CartData()],200, Front::getHeaderScript());
}
