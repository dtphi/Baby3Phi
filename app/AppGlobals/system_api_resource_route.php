<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

// Array admin controller.
const RESOURCE_CONTROLLERS = [
    'User', 'InformationCategory', 'Information', 'Setting', 'Album', 'GroupAlbum', 'RestrictIp'
];

// 1.Album category manage screen.
const ALBUM_CATEGORY_RESOURCE_NAME = 'group-albums';
const ALBUM_CATEGORY_REQUEST_NAME = 'GroupAlbumsRequest';

// 2.Album manage screen.
const ALBUM_RESOURCE_NAME = 'albums';
const ALBUM_REQUEST_NAME = 'AlbumsRequest';

// 3.User manage screen.
const USER_RESOURCE_NAME = 'admin';
const USER_REQUEST_NAME = 'AdminRequest';

// 4.Information category manage screen.
const INFORMATION_CATEGORY_RESOURCE_NAME = 'newsgroup';
const INFORMATION_CATEGORY_REQUEST_NAME = 'InformationCategoryRequest';

// 5.Information manage screen.
const INFORMATION_RESOURCE_NAME = 'information';
const INFORMATION_REQUEST_NAME = 'InformationRequest';

// 6.Setting manage screen.
const SETTING_RESOURCE_NAME = 'setting';
const SETTING_REQUEST_NAME = 'SettingRequest';

// 7.Restrict ip mange screen.
const RESTRICT_IP_RESOURCE_NAME = 'restrict-ip';
const RESTRICT_IP_REQUEST_NAME = 'RestrictIpRequest';

/**
 * Api route for admin for this rule.
 */
function b3p_api_resource_route() {
    return function () {
        foreach (RESOURCE_CONTROLLERS as $resource) {
            Route::apiResource(Str::snake($resource . 's', '-'), $resource . 'Controller');
        }
        Route::any('/mmedia/{any}', function () {});
      };
};
