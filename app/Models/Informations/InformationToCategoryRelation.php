<?php

namespace App\Models\Informations;

trait InformationToCategoryRelation
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }
}
