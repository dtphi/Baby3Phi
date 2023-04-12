<?php

namespace App\Models\Informations;

use App\Http\Common\Tables;
use App\Models\Tag;

trait InformationAttribute
{
    /**
     * @author : dtphi .
     * @param $value
     * @return mixed
     */
    public function getImageAttribute($value)
    {
        $imgThumb = $value;
        if (is_null($imgThumb)) {
            $value = NO_THUMB_IMG;
            $imgThumb = $value;
        }
        if (isset($this->image_thumb)
            && $this->image_thumb
            && file_exists(public_path('/.tmb' . $this->image_thumb))) {
            $imgThumb = '/.tmb' . $this->image_thumb;
        }

        return [
            'basename'  => "",
            'dirname'   => "",
            'extension' => "",
            'filename'  => "",
            'path'      => $value,
            'size'      => 0,
            'timestamp' => null,
            'type'      => null,
            'thumb'     => $imgThumb
        ];
    }

    /**
     * @author : dtphi .
     * @param $value
     * @return mixed
     */
    public function getDateAvailableAttribute($value)
    {
        return $value;
    }

    /**
     * @author : dtphi .
     * @param $value
     * @return int
     */
    public function getSortOrderAttribute($value)
    {
        return (int)$value;
    }

    /**
     * @author : dtphi .
     * @param $value
     * @return int
     */
    public function getViewedAttribute($value)
    {
        return (int)$value;
    }

    /**
     * @author : dtphi .
     * @param $value
     * @return int
     */
    public function getStatusAttribute($value)
    {
        return (int)$value;
    }

    public function getStatusTextAttribute($value)
    {
        return Tables::$infoStatus[$this->status];
    }

    /**
     * @author : dtphi .
     * @param $value
     * @return string
     */
    public function getNameAttribute($value)
    {
        $value = ($this->infoDes) ? $this->infoDes->name : '';

        return $value;
    }

    /**
     * @author : dtphi .
     * @param $value
     * @return string
     */
    public function getDescriptionAttribute($value)
    {
        $value = ($this->infoDes) ? $this->infoDes->description : '';

        return $value;
    }

    /**
     * @author : dtphi .
     * @param $value
     * @return string
     */
    public function getMetaTitleAttribute($value)
    {
        $value = ($this->infoDes) ? $this->infoDes->meta_title : '';

        return $value;
    }

    /**
     * @author : dtphi .
     * @param $value
     * @return string
     */
    public function getMetaDescriptionAttribute($value)
    {
        $value = ($this->infoDes) ? $this->infoDes->meta_description : '';

        return $value;
    }

    /**
     * @author : dtphi .
     * @param $value
     * @return string
     */
    public function getTagAttribute($value)
    {
        $arrTags = [];
        $value = ($this->infoDes) ? $this->infoDes->tag : '';
        if (!empty($value)) {
            $collection = Tag::whereIn('id', explode('|', $value))
                ->get();
            foreach ($collection as $tag) {
                $arrTags[] = $tag->name;
            }
        }

        return implode(',', $arrTags);
    }

    /**
     * @author : dtphi .
     * @param $value
     * @return string
     */
    public function getMetaKeywordAttribute($value)
    {
        $value = ($this->infoDes) ? $this->infoDes->meta_keyword : '';

        return $value;
    }

    /**
     * @author : dtphi .
     * @param $value
     * @return array
     */
    public function getArrRelatedListAttribute($value)
    {
        $relateds = [];
        if ($this->relateds) {
            foreach ($this->relateds as $related) {
                $relateds[] = (int)$related->related_id;
            }
        }

        return $relateds;
    }

    public function getSpecialCarouselsAttribute($value)
    {
        $value = [];
        if ($this->infoCarousel) {
            if ($this->infoCarousel->image) {
                $value = unserialize($this->infoCarousel->image);
            }
        }

        return $value;
    }

    /**
     * @author : dtphi .
     * @param $value
     * @return array
     */
    public function getArrImageListAttribute($value)
    {
        $value = [];
        if ($this->images) {
            foreach ($this->images as $image) {
                $value[] = [
                    'image'      => $image->image,
                    'sort_order' => (int)$image->sort_order
                ];
            }
        }

        return $value;
    }

    /**
     * @author : dtphi .
     * @param $value
     * @return array
     */
    public function getArrAlbumListAttribute($value)
    {
        $value = [];
        if ($this->albumImages) {
            foreach ($this->albumImages as $image) {
                $value[] = [
                    'album_id' => $image->album_id,
                    'name' => $image->album_name,
                    'image_origin' => $image->image_origin,
                    'images'      => $image->arr_image_list
                ];
            }
        }

        return $value;
    }

    /**
     * @author : dtphi .
     * @param $value
     * @return array
     */
    public function getArrDownloadListAttribute($value)
    {
        $value = [];
        if ($this->downloads) {
            foreach ($this->downloads as $download) {
                $value[] = (int)$download->download_id;
            }
        }

        return $value;
    }

    /**
     * @author : dtphi .
     * @param $value
     * @return array
     */
    public function getArrCategoryListAttribute($value)
    {
        $value = [];
        if ($this->categories) {
            foreach ($this->categories as $category) {
                $value[] = (int)$category->category_id;
            }
        }

        $this->setArrCategoryDisplayList($value);

        return $value;
    }

    public function getcategoryDisplayListAttribute($value)
    {
        return $this->categoryDisplayList;
    }

    /**
     * @author : dtphi .
     * @param $value
     * @return string
     */
    public function getGroupNameAttribute($value)
    {
        if (is_null($this->group)) {
            return ucfirst($value);
        }

        return ucfirst($this->group->newsgroupname);
    }
}
