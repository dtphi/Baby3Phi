<?php

namespace App\Models;

use App\Contacts\Apis\Admins\Models\InformationAlbum as ModelAlbum;
use DB;
use App\Models\BaseModel;
use App\Http\Common\Tables;
use App\Models\InformationAlbums\AlbumAttribute;
use App\Models\InformationAlbums\AlbumRelation;
use App\Models\InformationAlbums\AlbumScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Albums extends BaseModel implements ModelAlbum
{
    use HasFactory;
    use SoftDeletes;
    use AlbumRelation;
    use AlbumAttribute;
    use AlbumScope;

    protected $table = Tables::tbl_albums;

    protected $fillable = [
        'albums_name',
        'group_albums_id',
        'status',
        'sort_id',
        'image_origin',
        'image_thumb',
        'image',
        'update_user'
    ];

    public static function fcDeleteById(int $id): void
    {
        DB::delete("delete from `" . Tables::tbl_albums . "` where id = '" . $id . "'");
    }
}
