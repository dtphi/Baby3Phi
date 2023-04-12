<?php

namespace App\Models;

use App\Contacts\Apis\Admins\Models\Category as ModelCategory;
use App\Http\Common\Tables;
use App\Models\Categories\CategoryAttribute;
use App\Models\Categories\CategoryRelation;
use App\Models\Categories\CategoryScope;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends BaseModel implements ModelCategory
{
    use SoftDeletes;
    use CategoryRelation;
    use CategoryAttribute;
    use CategoryScope;

    /**
     * @var string
     */
    protected $table = Tables::tbl_categorys;

    /**
     * @var string
     */
    protected $primaryKey = 'category_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image',
        'parent_id',
        'top',
        'name_slug',
        'tag',
        'column',
        'sort_order',
        'status',
        'user_create'
    ];

    /**
     * @author : dtphi .
     * @param array $data
     * @return array
     */
    public static function getInformationCategorys(array $data): array
    {
        $query = self::select('id', 'father_id', 'newsgroupname')->orderByDesc('id');

        return [
            'total' => $query->count(),
            'data'  => $query->get()->toArray()
        ];
    }

    /**@author : dtphi .
     * @param $cateId
     */
    public static function fcDeleteByCateId(int $cateId): void
    {
        DB::delete("delete from `" . Tables::tbl_categorys . "` where category_id = '" . $cateId . "'");
    }

    public static function insertForce(
        int $cateId = null,
        string $nameSlug = '',
        int $parentId = null,
        int $createUser = 0,
        int $status = 1
    ): void {
        $cateId   = (int)$cateId;
        $parentId = (int)$parentId;
        if ($parentId == -1) {
            $parentId = 0;
        }

        if ($cateId) {
            DB::insert(
                'insert into ' . Tables::tbl_categorys . ' (category_id, parent_id, status, name_slug, user_create) values (?, ?, ?, ?, ?)',
                [$cateId, $parentId, $status, $nameSlug, $createUser]
            );
        }
    }

    public static function truncateForce(): void
    {
        DB::statement('truncate table ' . Tables::tbl_categorys);
    }
}
