<?php

namespace App\AppGlobals;

/**
 * Class ApiPermissionConstants
 *
 * @package App\Helpers
 */
final class ApiPermissionConstants
{
    const PREFIX_ACCESS_NAME = 'allow.';
    const PREFIX_SETTING = 'setting';
    const PREFIX_ALLOW_GROUP_ALBUMS = 'album.group';
    const PREFIX_ALLOW_ALBUMS = 'album';
    const PREFIX_ALLOW_NEWS_GROUP = 'news.group';
    const PREFIX_ALLOW_TIN_TUC = 'tin.tuc';
    const PREFIX_ALLOW_SLIDE_INFO_SPECIAL = 'slide.info.specials';
    const PREFIX_ALLOW_RESTRICT_IP = 'restrict.ip';

    const RULE_SETTING_CODE = 'system_rule';
    const RULE_SETTING_KEY_DATA = 'system_rule_allow';
    const RULE_ACTION_SELECT = ['list' => false, 'add' => false, 'edit' => false, 'delete' => false];
    const RULE_SELECT = [
        'setting' => ['abilities' => self::RULE_ACTION_SELECT, 'all' => false],
        'news_group' => ['abilities' => self::RULE_ACTION_SELECT, 'all' => false],
        'tin_tuc' => ['abilities' => self::RULE_ACTION_SELECT, 'all' => false],
        'slide_info_specials' => ['abilities' => self::RULE_ACTION_SELECT, 'all' => false],
        'album_group' => ['abilities' => self::RULE_ACTION_SELECT, 'all' => false],
        'album' => ['abilities' => self::RULE_ACTION_SELECT, 'all' => false],
    ];
    const NETWORK_TARGET = ['facebook', 'twitter', 'linkedin', 'reddit'];
}
