<?php

namespace App\Models\Categories;

use App\Http\Common\Tables;

trait CategoryScope
{
    public function scopeFilterParentId($query, $parentId = 0)
    {
        $query->where($this->table . '.parent_id', (int)$parentId);

        return $query;
    }

    public function scopeFilterActiveStatus($query)
    {
        $query->where($this->table . '.status', Tables::$infoStatusActive);

        return $query;
    }

    public function scopeOrderByAscSort($query)
    {
        $query->orderBy($this->table . '.sort_order', 'asc');

        return $query;
    }

    public function scopeOrderByAscParentId($query)
    {
        $query->orderBy($this->table . '.parent_id', 'asc');

        return $query;
    }

    public function scopeFilterById($query, $categoryId)
    {
        $query->where($this->table . '.category_id', (int)$categoryId);

        return $query;
    }

    public function scopeFilterInByIds($query, $categoryIds = [])
    {
        $query->whereIn($this->table . '.category_id', $categoryIds);

        return $query;
    }

    public function scopeFilterLayoutId($query, $layoutId)
    {
        $query->where(Tables::tbl_category_to_layouts . '.layout_id', (int)$layoutId);

        return $query;
    }

    public function scopeLfJoinDescription($query)
    {
        $query->leftJoin(
            Tables::tbl_category_descriptions,
            $this->table . '.category_id',
            '=',
            Tables::tbl_category_descriptions . '.category_id'
        );

        return $query;
    }

    public function scopeLfJoinToLayout($query)
    {
        $query->leftJoin(
            Tables::tbl_category_to_layouts,
            $this->table . '.category_id',
            '=',
            Tables::tbl_category_to_layouts . '.category_id'
        );

        return $query;
    }
}
