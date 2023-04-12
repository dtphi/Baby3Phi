<?php

namespace App\Models;

use App\Http\Common\Tables;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends BaseModel
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = Tables::tbl_tags;

    /**
     * Filter .
     */
    protected $fillable = [
      'name',
      'name_slug',
      'active',
      'update_user',
    ];
}
