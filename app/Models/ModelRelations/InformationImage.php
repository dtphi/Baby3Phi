<?php

namespace App\Models\ModelRelations;

use App\Http\Common\Tables;
use App\Models\BaseModel;
use App\Models\Informations\InformationImageAttribute;
use App\Models\Informations\InformationImageRelation;
use App\Models\Informations\InformationImageScope;
use DB;

class InformationImage extends BaseModel
{
    use InformationImageRelation;
    use InformationImageAttribute;
    use InformationImageScope;

    /**
     * @var string
     */
    protected $table = Tables::tbl_information_images;

    /**
     * @var string
     */
    protected $primaryKey = 'infomation_image_id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'infomation_id',
        'album_id',
        'image',
        'sort_order'
    ];

    public static function insertByInfoId($infoId = null, $image = '', $sortOrder = 0)
    {
        $infoId = (int)$infoId;

        if ($infoId && !empty($image)) {
            DB::insert('insert into ' . Tables::tbl_information_images . ' (information_id, image, sort_order) values (?, ?, ?)',
                [
                    $infoId,
                    $image,
                    $sortOrder
                ]);
        }
    }
    public static function insertAlbumByInfoId($infoId = null, $albumId = null)
    {
        $infoId = (int)$infoId;
        $albumId = (int)$albumId;

        if ($infoId && $albumId) {
            DB::insert('insert into ' . Tables::tbl_information_images . ' (information_id, album_id) values (?, ?)',
                [
                    $infoId,
                    $albumId
                ]);
        }
    }
    public static function fcDeleteByInfoId($infoId = null)
    {
        $infoId = (int)$infoId;

        if ($infoId) {
            return DB::delete("delete from " . Tables::tbl_information_images . " where information_id = '" . $infoId . "'");
        }
    }
}
