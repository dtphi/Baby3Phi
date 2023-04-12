<?php

namespace App\Models\ModelRelations;

use App\Http\Common\Tables;
use App\Models\BaseModel;
use App\Models\Categories\CategoryToLayoutAttribute;
use App\Models\Categories\CategoryToLayoutRelation;
use App\Models\Categories\CategoryToLayoutScope;
use DB;

class CategoryToLayout extends BaseModel
{
    use CategoryToLayoutRelation;
    use CategoryToLayoutAttribute;
    use CategoryToLayoutScope;

    /**
     * @var string
     */
    protected $table = Tables::tbl_category_to_layouts;

    /**
     * @var string
     */
    protected $primaryKey = ['category_id', 'layout_id'];

    public $timestamps = false;

    /**
     * @author : dtphi .
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'layout_id'
    ];

    /**
     * @author : dtphi .
     * @param null $cateId
     * @return mixed
     */
    public static function fcDeleteByCateId($cateId = null)
    {
        $cateId = (int)$cateId;

        if ($cateId) {
            return DB::delete("delete from `" . Tables::tbl_category_to_layouts . "` where " . Tables::tbl_category_to_layouts . ".category_id = '" . $cateId . "'");
        }
    }

    /**
     * @author : dtphi .
     * @param null $cateId
     * @param null $layoutId
     * @return mixed
     */
    public static function insertByCateId($cateId = null, $layoutId = null)
    {
        $cateId   = (int)$cateId;
        $layoutId = (int)$layoutId;

        if ($cateId && $layoutId) {
            return DB::insert('insert into ' . Tables::tbl_category_to_layouts . ' (category_id, layout_id) values (?, ?)',
                [$cateId, $layoutId]);
        }

    }
}
