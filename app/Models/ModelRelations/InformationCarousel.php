<?php

namespace App\Models\ModelRelations;

use App\Http\Common\Tables;
use App\Models\BaseModel;
use DB;

class InformationCarousel extends BaseModel
{
    /**
     * @var string
     */
    protected $table = Tables::tbl_information_carousels;

    /**
     * @var string
     */
    protected $primaryKey = 'information_id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'infomation_id',
        'name',
        'name_slug',
        'sort_description',
        'description',
        'image_origin',
        'image',
        'sort_order',
        'date_available',
        'information_type',
        'viewed',
        'vote'
    ];

    public static function insertByInfoId($infoId = null, $data = [])
    {
        $infoId = (int)$infoId;

        if ($infoId) {
            DB::insert('insert into ' . Tables::tbl_information_carousels . ' (information_id, name, name_slug, sort_description, image_origin, image, sort_order, date_available, information_type, viewed, vote) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                [
                    $infoId,
                    $data['name'],
                    $data['name_slug'],
                    $data['sort_description'],
                    $data['image_origin'],
                    $data['image'],
                    $data['sort_order'],
                    $data['date_available'],
                    $data['information_type'],
                    $data['viewed'],
                    $data['vote']
                ]);
        }
    }
}
