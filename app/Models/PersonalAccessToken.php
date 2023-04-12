<?php

namespace App\Models;

use App\Contacts\Apis\Admins\Models\PersonalAccessToken as ModelPersonalAccessToken;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;
use App\Http\Common\Tables;
use DB;

class PersonalAccessToken extends SanctumPersonalAccessToken implements ModelPersonalAccessToken
{
    protected $table = Tables::tbl_personal_access_tokens;

    public function can($ability)
    {
        return in_array('*', $this->abilities) ||
               array_key_exists($ability, array_flip($this->abilities));
    }

    public static function fcDeleteByTokenableId(int $tokenableId = null)
    {
        $tokenableId = (int)$tokenableId;

        if ($tokenableId) {
            $whereId = " where tokenable_id = '" . $tokenableId . "'";
            $whereName = " and name <> 'allow.all'";
            $whereAbilities = " and abilities <> '[*]'";
            return DB::delete("delete from " . Tables::tbl_personal_access_tokens . $whereId . $whereName . $whereAbilities);
        }
    }
}
