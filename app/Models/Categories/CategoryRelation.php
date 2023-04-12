<?php

namespace App\Models\Categories;

use App\Models\ModelRelations\CategoryDescription;

trait CategoryRelation
{
    /**
     * @author : dtphi .
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function description()
    {
        return $this->hasOne(CategoryDescription::class, $this->primaryKey);
    }
}
