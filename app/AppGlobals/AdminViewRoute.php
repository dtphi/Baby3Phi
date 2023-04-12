<?php
namespace App\AppGlobals;

final class AdminViewRoute
{
    public static $arrRouteViews = [
        'admin_dashboards' => [
            'uri' => '/admin/dashboards',
        ],
        'admin_users' => [
            'uri' => '/admin/users',
        ],
        'admin_product' => [
            'uri' => '/admin/product',
            'view' => 'statics/admin/product/index',
            'where' => [
                'product' => 'product.*'
            ]
        ],
        'admin_filemanagers' => [
            'uri' => '/admin/filemanagers',
        ],
        'admin_system' => [
            'uri' => '/admin/system',
        ],
        'admin_news-categories' => [
            'uri' => '/admin/{newsCategory}',
            'where' => [
                'newsCategory' => 'news-categories.*'
            ]
        ],
        'admin_informations' => [
            'uri' => '/admin/{information}',
            'where' => [
                'information' => 'informations.*'
            ]
        ],
        'admin_group-albums' => [
            'uri' => '/admin/{groupAlbum}',
            'where' => [
                'groupAlbum' => 'group-albums.*'
            ]
        ],
        'admin_albums' => [
            'uri' => '/admin/{album}',
            'where' => [
                'album' => 'albums.*'
            ]
        ],
        'admin_module-category-left-side-bars' => [
            'uri' => '/admin/{module}',
            'where' => [
                'module' => 'module-.*'
            ]
        ],
        'admin_module-home-banners' => [
            'uri' => '/admin/{module}',
            'where' => [
                'module' => 'module-.*'
            ]
        ],
        'admin_module-category-icon-side-bars' => [
            'uri' => '/admin/{module}',
            'where' => [
                'module' => 'module-.*'
            ]
        ],
        'admin_module-noi-bats' => [
            'uri' => '/admin/{module}',
            'where' => [
                'module' => 'module-.*'
            ]
        ],
        'admin_restrict-ips' => [
            'uri' => '/admin/{restrictIp}',
            'where' => [
                'restrictIp' => 'restrict-ips.*'
            ]
        ]
    ];
}
