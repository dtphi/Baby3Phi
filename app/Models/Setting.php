<?php

namespace App\Models;

use App\Contacts\Apis\Admins\Models\Setting as ModelSetting;
use App\Http\Common\Tables;
use DB;

class Setting extends BaseModel implements ModelSetting
{
    protected $table = Tables::tbl_settings;

    /**
     * @var string
     */
    protected $primaryKey = 'setting_id';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @author : dtphi .
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'key_data',
        'value',
        'serialized'
    ];

    public static function forceInsert(
        string $code,
        string $key,
        $value = null,
        $serialized = 1
    ) {
        $serialized = (int)$serialized;

        if (!empty($code) && !empty($key)) {

            $insertQuery = 'insert into ' . Tables::tbl_settings . ' (code, key_data, value, serialized) values (?, ?, ?, ?)';

            return DB::insert($insertQuery, [$code, $key, $value, $serialized]);
        }
    }

    public static function forceDeleteByCode(string $code)
    {
        if ($code) {
            return DB::delete("delete from " . Tables::tbl_settings . " where code = '" . $code . "'");
        }
    }

    public function scopeFilterCode($query, $code = '')
    {
        if (is_array($code)) {
            return $query->whereIn($this->table . '.code', $code);
        }
        $query->where($this->table . '.code', $code);

        return $query;
    }

    public function scopeFilterKey($query, $key = '')
    {
        $query->where($this->table . '.key_data', $key);

        return $query;
    }
}
