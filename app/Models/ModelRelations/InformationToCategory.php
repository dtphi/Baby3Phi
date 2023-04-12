<?php

namespace App\Models\ModelRelations;

use App\Http\Common\Tables;
use App\Models\BaseModel;
use App\Models\Informations\InformationToCategoryAttribute;
use App\Models\Informations\InformationToCategoryRelation;
use App\Models\Informations\InformationToCategoryScope;
use DB;

class InformationToCategory extends BaseModel
{
    use InformationToCategoryRelation;
    use InformationToCategoryAttribute;
    use InformationToCategoryScope;

    /**
     * @var string
     */
    protected $table = Tables::tbl_information_to_categorys;

    /**
     * @var string
     */
    protected $primaryKey = ['infomation_id', 'category_id'];

    public $timestamps = false;

    //public $incrementing = false;

    /**
     * @author : dtphi .
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'infomation_id',
        'category_id'
    ];

    public static function fcDeleteByCateId($cateId = null)
    {
        $cateId = (int)$cateId;

        if ($cateId) {
            return DB::delete("delete from `" . Tables::tbl_information_to_categorys . "` where category_id = '" . $cateId . "'");
        }
    }

    public static function insertByInfoId($infoId = null, $cateId = null)
    {
        $infoId = (int)$infoId;
        $cateId = (int)$cateId;

        if ($infoId && $cateId) {
            DB::insert('insert into ' . Tables::tbl_information_to_categorys . ' (information_id, category_id) values (?, ?)',
                [
                    $infoId,
                    $cateId
                ]);
        }
    }

    public static function fcDeleteByInfoId($infoId = null)
    {
        $infoId = (int)$infoId;

        if ($infoId) {
            return DB::delete("delete from " . Tables::tbl_information_to_categorys . " where information_id = '" . $infoId . "'");
        }
    }

    public static function truncateForce()
    {
        DB::statement('truncate table ' . Tables::tbl_information_to_categorys);
    }
}
