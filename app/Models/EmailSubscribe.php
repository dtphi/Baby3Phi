<?php

namespace App\Models;

use App\Http\Common\Tables;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailSubscribe extends Model
{
    use HasFactory;

    protected $table = Tables::tbl_subscribes;

    /**
     * @var string
     */
    protected $primaryKey = 'subscribe_id';


    protected $fillable = [
        'email'
    ];
}
