<?php

namespace App\Models\Informations;

use App\Models\Albums;

trait InformationImageRelation
{
    /**
     * @author : dtphi .
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function album()
    {
        return $this->belongsTo(Albums::class, 'album_id');
    }
}
