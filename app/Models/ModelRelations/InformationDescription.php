<?php

namespace App\Models\ModelRelations;

use App\Http\Common\Tables;
use App\Models\BaseModel;
use App\Models\Informations\InformationDescriptionAttribute;
use App\Models\Informations\InformationDescriptionRelation;
use App\Models\Informations\InformationDescriptionScope;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class InformationDescription extends BaseModel
{
    use SoftDeletes;
    use InformationDescriptionRelation;
    use InformationDescriptionAttribute;
    use InformationDescriptionScope;

    /**
     * @var string
     */
    protected $table = Tables::tbl_information_descriptions;

    /**
     * @var string
     */
    protected $primaryKey = 'information_id';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'tag',
        'meta_title',
        'meta_description',
        'meta_keyword'
    ];

    public static function insertByInfoId(
        $infoId = null,
        $name = '',
        $description = '',
        $tag = '',
        $metaTitle = '',
        $metaDescription = '',
        $metaKeyword = ''
    ) {
        $infoId = (int)$infoId;

        if ($infoId && !empty($name) && !empty($metaTitle)) {
            DB::insert('insert into ' . Tables::tbl_information_descriptions . ' (information_id, name, description, tag, meta_title, meta_description, meta_keyword) values (?, ?, ?, ?, ?, ?, ?)',
                [
                    $infoId,
                    $name,
                    $description,
                    $tag,
                    $metaTitle,
                    $metaDescription,
                    $metaKeyword
                ]);
        }
    }

    public static function fcDeleteByInfoId($infoId = null)
    {
        $infoId = (int)$infoId;

        if ($infoId) {
            return DB::delete("delete from " . Tables::tbl_information_descriptions . " where information_id = '" . $infoId . "'");
        }
    }

    public static function truncateForce()
    {
        DB::statement('truncate table ' . Tables::tbl_information_descriptions);
    }
}
