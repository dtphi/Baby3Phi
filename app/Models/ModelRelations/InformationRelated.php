<?php

namespace App\Models\ModelRelations;

use App\Http\Common\Tables;
use App\Models\BaseModel;
use App\Models\Informations\InformationRelatedAttribute;
use App\Models\Informations\InformationRelatedRelation;
use App\Models\Informations\InformationRelatedScope;
use DB;

class InformationRelated extends BaseModel
{
    use InformationRelatedRelation;
    use InformationRelatedAttribute;
    use InformationRelatedScope;

    /**
     * @var string
     */
    protected $table = Tables::tbl_information_relateds;

    /**
     * @var string
     */
    protected $primaryKey = ['information_id', 'related_id'];

    public $timestamps = false;

    /**
     * @author : dtphi .
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'information_id',
        'related_id'
    ];

    public static function fcDeleteByInfoAndRelatedId($infoId = null, $relatedId = null)
    {
        $infoId    = (int)$infoId;
        $relatedId = (int)$relatedId;

        if ($infoId && $relatedId) {
            return DB::delete("delete from `" . Tables::tbl_information_relateds . "` where " . Tables::tbl_information_relateds . ".information_id = '" . $infoId . "' and " . Tables::tbl_information_relateds . ".related_id = '" . $relatedId . "'");
        }
    }

    public static function insertByInfoId($infoId = null, $relatedId = null)
    {
        $infoId    = (int)$infoId;
        $relatedId = (int)$relatedId;

        if ($infoId && !empty($relatedId)) {
            DB::insert('insert into ' . Tables::tbl_information_relateds . ' (information_id, related_id) values (?, ?)', [
                $infoId,
                $relatedId
            ]);
        }
    }

    public static function fcDeleteByInfoId($infoId = null)
    {
        $infoId = (int)$infoId;

        if ($infoId) {
            return DB::delete("delete from " . Tables::tbl_information_relateds . " where information_id = '" . $infoId . "'");
        }
    }

    public static function fcDeleteByRelatedId($relatedId = null)
    {
        $relatedId = (int)$relatedId;

        if ($relatedId) {
            return DB::delete("delete from " . Tables::tbl_information_relateds . " where related_id = '" . $relatedId . "'");
        }
    }
}
