<?php

namespace App\Http\Common;

use App\AppGlobals\ApiPermissionConstants as ApiPermission;

final class Tables
{
  const tbl_admins = TBL_PREFIX . 'admins';
    const tbl_layout_routes = TBL_PREFIX . 'layout_routes';
    const tbl_layout_settings = TBL_PREFIX . 'layout_settings';
    const tbl_subscribes = TBL_PREFIX . 'subscribes';
    const tbl_categorys = TBL_PREFIX . 'categorys';
    const tbl_category_to_layouts = TBL_PREFIX . 'category_to_layouts';
    const tbl_category_paths = TBL_PREFIX . 'category_paths';
    const tbl_category_descriptions = TBL_PREFIX . 'category_descriptions';
    const tbl_informations = TBL_PREFIX . 'informations';
    const tbl_information_to_downloads = TBL_PREFIX . 'information_to_downloads';
    const tbl_information_to_categorys = TBL_PREFIX . 'information_to_categorys';
    const tbl_information_relateds = TBL_PREFIX . 'information_relateds';
    const tbl_information_images = TBL_PREFIX . 'information_images';
    const tbl_information_descriptions = TBL_PREFIX . 'information_descriptions';
    const tbl_information_carousels = TBL_PREFIX . 'information_corousels';
    const tbl_settings = TBL_PREFIX . 'settings';
    const tbl_tags = TBL_PREFIX . 'tags';
    const tbl_personal_access_tokens = TBL_PREFIX . 'personal_access_tokens';
    const tbl_restrict_ips = TBL_PREFIX . 'restrict_ips';
    const tbl_albums = TBL_PREFIX . 'albums';
    const tbl_group_albums = TBL_PREFIX . 'group_albums';

    public static $infoStatus = [
        'Ẩn',
        'Xảy ra'
    ];
    public static $infoStatusActive = 1;
    public static $infoStatusDisabled = 0;
    public static $tagetLink = [
        '_blank',
        '_self'
    ];

    public static $settingAccessName = ApiPermission::PREFIX_ACCESS_NAME . ApiPermission::PREFIX_SETTING;
    public static $groupAlbumsAccessName = ApiPermission::PREFIX_ACCESS_NAME . ApiPermission::PREFIX_ALLOW_GROUP_ALBUMS;
    public static $albumsAccessName = ApiPermission::PREFIX_ACCESS_NAME . ApiPermission::PREFIX_ALLOW_ALBUMS;
    public static $categoryAccessName = ApiPermission::PREFIX_ACCESS_NAME . ApiPermission::PREFIX_ALLOW_NEWS_GROUP;
    public static $tinTucAccessName = ApiPermission::PREFIX_ACCESS_NAME . ApiPermission::PREFIX_ALLOW_TIN_TUC;
    public static $slideInfoSpecialAccessName = ApiPermission::PREFIX_ACCESS_NAME . ApiPermission::PREFIX_ALLOW_SLIDE_INFO_SPECIAL;
    public static $restrictIpAccessName = ApiPermission::PREFIX_ACCESS_NAME . ApiPermission::PREFIX_ALLOW_RESTRICT_IP;
}
