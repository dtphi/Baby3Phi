<?php

namespace App\Models\ModelRelations;

use App\Models\BaseModel;
use App\Models\Informations\InformationCategoryAttribute;
use App\Models\Informations\InformationCategoryRelation;
use App\Models\Informations\InformationCategoryScope;

class InformationCategory extends BaseModel
{
    use InformationCategoryAttribute;
    use InformationCategoryRelation;
    use InformationCategoryScope;

    protected $table = 'news_groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'father_id',
        'newsgroupname',
        'user_id',
        'description',
        'displays',
        'sort'
    ];

    /**
     * [getInformationCategorys description]
     * @param  array $data [description]
     * @return [type]       [description]
     */
    public static function getInformationCategorys(array $data)
    {
        $query = self::select('id', 'father_id', 'newsgroupname')->orderByDesc('id');

        return [
            'total' => $query->count(),
            'data'  => $query->get()->toArray()
        ];
    }
}
