<?php

namespace App\Models\Informations;

use App\Models\ModelRelations\InformationCarousel;
use App\Models\ModelRelations\InformationDescription;
use App\Models\ModelRelations\InformationImage;
use App\Models\ModelRelations\InformationRelated;
use App\Models\ModelRelations\InformationToCategory;
use App\Models\ModelRelations\InformationToDownload;

trait InformationRelatedRelation
{
    /**
     * @author : dtphi .
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function infoDes()
    {
        return $this->hasOne(InformationDescription::class, $this->primaryKey);
    }

    /**
     * @author : dtphi .
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function relateds()
    {
        return $this->hasMany(InformationRelated::class, $this->primaryKey);
    }

    /**
     * @author : dtphi .
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->hasMany(InformationToCategory::class, $this->primaryKey);
    }

    /**
     * @author : dtphi .
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(InformationImage::class, $this->primaryKey)->whereNull('album_id');
    }

    /**
     * @author : dtphi .
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function albumImages()
    {
        return $this->hasMany(InformationImage::class, $this->primaryKey)->where('album_id', '>', 0);
    }

    /**
     * @author : dtphi .
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function infoCarousel()
    {
        return $this->hasOne(InformationCarousel::class, $this->primaryKey);
    }

    /**
     * @author : dtphi .
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function downloads()
    {
        return $this->hasMany(InformationToDownload::class, $this->primaryKey);
    }
}
