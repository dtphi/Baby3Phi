<?php

namespace App\Models;

use App\Contacts\Apis\Admins\Models\InformationAlbumCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Common\Tables;
use App\Models\InformationAlbumCategories\AlbumCategoryAttribute;
use App\Models\InformationAlbumCategories\AlbumCategoryRelation;
use App\Models\InformationAlbumCategories\AlbumCategoryScope;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupAlbums extends BaseModel implements InformationAlbumCategory
{
    use HasFactory;
    use SoftDeletes;
    use AlbumCategoryRelation;
    use AlbumCategoryAttribute;
    use AlbumCategoryScope;

    protected $table = Tables::tbl_group_albums;

    protected $fillable = [
        'group_name',
        'status',
        'sort_id',
        'update_user'
    ];

    public static function fcDeleteById(int $id): void
    {
        DB::delete("delete from `" . Tables::tbl_group_albums . "` where id = '" . $id . "'");
    }
}
