<?php
namespace App\AppGlobals;

use DB;
use Log;
use Request;

final class Front
{
    /**
     * @var array
     */
    public $cssSetting = [];

    /**
     * InitContent constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return array
     */
    public static function getHeaderScript()
    {
        if (isset($_SERVER['HTTP_SEC_FETCH_DEST']) && ($_SERVER['HTTP_SEC_FETCH_DEST'] == 'script')) {
            return ['Content-Type' => 'text/javascript; charset=UTF-8'];
        }

        return [];
    }
}
