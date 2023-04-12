<?php

namespace App\Models;

use App\Contacts\Apis\Admins\Models\Information as ModelInformation;
use App\Http\Common\Tables;
use App\Models\Informations\InformationAttribute;
use App\Models\Informations\InformationRelation;
use App\Models\Informations\InformationScope;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Information extends BaseModel implements ModelInformation
{
    use SoftDeletes;
    use InformationRelation;
    use InformationAttribute;
    use InformationScope;

    /**
     * @var string
     */
    protected $table = Tables::tbl_informations;

    /**
     * @var string
     */
    protected $primaryKey = 'information_id';

    /**
     * @author : dtphi .
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image',
        'image_thumb',
        'information_type',
        'user_create',
        'name_slug',
        'sort_description',
        'date_available',
        'sort_order',
        'status',
        'viewed'
    ];

    /**
     * @var array
     */
    protected $categoryDisplayList = [];

    /**
     * @param : $infoId
     */
    public function sqlStatementIncrementViewed(int $infoId): string
    {
        return 'update ' . $this->table . ' set viewed = (viewed + 1) where information_id = ?';
    }

    public static function fcDeleteByInfoId($infoId = null)
    {
        $infoId = (int)$infoId;

        if ($infoId) {
            return DB::delete("delete from " . Tables::tbl_informations . " where information_id = '" . $infoId . "'");
        }
    }

    public function setArrCategoryDisplayList($value = [])
    {
        if (!empty($value)) {
            $modelPath = new CategoryPath();
            $models    = $modelPath->getQueryCategories()->whereIn('cate1.category_id', $value)->get();

            foreach ($models as $model) {
                $this->categoryDisplayList[] = [
                    'category_id' => $model->category_id,
                    'name'        => $model->name
                ];
            }
        }
    }

    public static function insertForce(
        $infoId = null,
        $image = null,
        $dateAvailable = null,
        $sortOrder = 0,
        $status = 1,
        $viewed = 0,
        $vote = 0,
        $sortDes = '',
        $nameSlug = '',
        $createUser = 0,
        $infoType = 1
    ) {
        $infoId = (int)$infoId;
        $viewed = (int)$viewed;
        $vote   = (int)$vote;

        if ($infoId) {
            DB::insert(
                'insert into ' . Tables::tbl_informations . ' (information_id, user_create, name_slug, image, date_available, sort_order, information_type, status, viewed, vote, sort_description) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                [
                    $infoId,
                    $createUser,
                    $nameSlug,
                    $image,
                    $dateAvailable,
                    $sortOrder,
                    $infoType,
                    $status,
                    $viewed,
                    $vote,
                    $sortDes
                ]
            );
        }
    }

    public static function truncateForce()
    {
        DB::statement('truncate table ' . Tables::tbl_informations);
    }
}
