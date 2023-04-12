<?php

namespace App\Models\ModelRelations;

use App\Http\Common\Tables;
use App\Models\BaseModel;
use App\Models\Categories\CategoryPathAttribute;
use App\Models\Categories\CategoryPathRelation;
use App\Models\Categories\CategoryPathScope;
use DB;

class CategoryPath extends BaseModel
{
    use CategoryPathScope;
    use CategoryPathAttribute;
    use CategoryPathRelation;

    /**
     * table name .
     */
    protected $table = Tables::tbl_category_paths;

    /**
     * @var string
     */
    public static $separate = ' >> ';

    /**
     * @author : dtphi .
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'path_id',
        'level'
    ];



    /**
     * @author : dtphi .
     * @param null $cateId
     * @return mixed
     */
    public static function fcDeleteByCateId($cateId = null)
    {
        if ($cateId) {
            return DB::delete("delete from `" . Tables::tbl_category_paths . "` where " . Tables::tbl_category_paths . ".category_id = '" . (int)$cateId . "'");
        }
    }

    // delete category_path with path id
    public static function fcDeleteByPathId($pathId = null)
    {
        if ($pathId) {
            return DB::delete("delete from `" . Tables::tbl_category_paths . "` where " . Tables::tbl_category_paths . ".path_id = '" . (int)$pathId . "'");
        }
    }
    public static function fcUpdateLevelByCateId($cateId = null, $level = 1)
    {
        (int)$result = $level - 1;
        if ($cateId) {
            return DB::statement("update `" . Tables::tbl_category_paths . "` set  level = '" . (int)$result . "' where  category_id = '" . (int)$cateId . "'");
        }
    }

    /**
     * @author : dtphi .
     * @param null $cateId
     * @param int $level
     * @return mixed
     */
    public static function fcDeleteByCateIdAndLevelDown($cateId = null, $level = 0)
    {
        if ($cateId) {
            return DB::delete("delete from `" . Tables::tbl_category_paths . "` where " . Tables::tbl_category_paths . ".category_id = '" . (int)$cateId . "' AND " . Tables::tbl_category_paths . ".level < '" . (int)$level . "'");
        }
    }

    /**
     * @author : dtphi .
     * @param null $cateId
     * @param null $pathId
     * @param int $level
     * @return mixed
     */
    public static function replaceByCateidAndPathAndLevel($cateId = null, $pathId = null, $level = 0)
    {
        if ($cateId && $pathId) {
            return DB::statement("REPLACE INTO `" . Tables::tbl_category_paths . "` SET " . Tables::tbl_category_paths . ".category_id = '" . (int)$cateId . "', " . Tables::tbl_category_paths . ".path_id = '" . (int)$pathId . "', " . Tables::tbl_category_paths . ".level = '" . (int)$level . "'");
        }
    }

    /**
     * @author : dtphi .
     * @param string $tbContainNameAlias
     * @param string $rawAlias
     * @return mixed
     */
    public static function getRawCategoryName($tbContainNameAlias = '', $rawAlias = 'name')
    {
        if (empty($tbContainNameAlias)) {
            $tbContainNameAlias = Tables::tbl_category_descriptions;
        }

        return DB::raw("group_concat(" . $tbContainNameAlias . ".`name` ORDER BY " . Tables::tbl_category_paths . ".level SEPARATOR '" . self::$separate . "') AS " . $rawAlias);
    }

    /**
     * @author : dtphi .
     * @param null $cateId
     * @param null $pathId
     * @param int $level
     * @return mixed
     */
    public static function insertByCateId($cateId = null, $pathId = null, $level = 0)
    {
        $cateId = (int)$cateId;
        $pathId = (int)$pathId;
        $level  = (int)$level;

        if ($cateId && $pathId) {
            return DB::insert(
                'insert into ' . Tables::tbl_category_paths . ' (category_id, path_id, level) values (?, ?, ?)',
                [$cateId, $pathId, $level]
            );
        }
    }

    public function getQueryCategories($data = array())
    {
        $cate1 = 'cate1';
        $cate2 = 'cate2';
        $cd1   = 'cd1';
        $cd2   = 'cd2';

        $query = $this->select(
            Tables::tbl_category_paths . '.category_id AS category_id',
            $cate1 . '.parent_id',
            $cate1 . '.sort_order',
            self::getRawCategoryName($cd1)
        )
            ->gbByCategoryId()
            ->ljoinCategory($cate1)
            ->ljoinCategory($cate2)
            ->ljoinCateDescription($cd1)
            ->ljoinCateDescription($cd2);

        return $query;
    }

    public static function truncateForce()
    {
        DB::statement('truncate table ' . Tables::tbl_category_paths);
    }
}
