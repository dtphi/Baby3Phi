<?php

/**
 * Init css for Backend.
 */

namespace App\ViewDatas\Admins;

use App\AppGlobals\AdminViewRoute;
use App\Http\Common\Tables;
use App\ViewDatas\BaseAdminData;
use Illuminate\Support\Facades\Route;

final class AdminData extends BaseAdminData
{
    private static $selfInstance = null;

    /**
     * CSS constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public static function instanceViewData()
    {
        if (is_null(self::$selfInstance)) {
            self::$selfInstance =  new self;
        }
        return self::$selfInstance;
    }

    public function routeView()
    {
        $b3pAdData = ['b3pAdData' => self::$selfInstance];

        Route::view('/admin/login', 'b3p-administrator', $b3pAdData);
        if (trim(request()->getRequestUri(), '/') == 'admin') {
            Route::view('/admin', 'b3p-administrator', $b3pAdData);

            return;
        }

        $reqUrls = explode('/', trim(request()->getRequestUri(), '/'));
        $viewPath = "$reqUrls[0]_$reqUrls[1]";

        $arrRouteViews = AdminViewRoute::$arrRouteViews;

        if (isset($arrRouteViews[$viewPath])) {
            $view = $arrRouteViews[$viewPath];
            $template = isset($view['view']) ? $view['view']: 'b3p-administrator';
            $viewRoute = Route::view($view['uri'], $template, $b3pAdData);
            if (isset($view['where'])) {
                $viewRoute->where($view['where']);
            }
        }
    }
}
