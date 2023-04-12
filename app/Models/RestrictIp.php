<?php

namespace App\Models;

use App\Contacts\Apis\Admins\Models\RestrictIp as ModelRestrictIp;
use DB;
use App\Http\Common\Tables;

class RestrictIp extends BaseModel implements ModelRestrictIp
{
  /**
   * @var string
   */
  protected $table = Tables::tbl_restrict_ips;

  protected $fillable = [
    'ip',
    'active',
    'update_user'
  ];

  public static function fcDeleteById(int $id)
  {
    DB::delete("delete from `" . Tables::tbl_restrict_ips . "` where id = '" . $id . "'");
  }
}
