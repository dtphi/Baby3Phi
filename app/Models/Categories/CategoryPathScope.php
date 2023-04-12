<?php

namespace App\Models\Categories;

use App\Http\Common\Tables;

trait CategoryPathScope
{
    /**
     * @author : dtphi .
     * @param $query
     * @return mixed
     */
    public function scopeGbByCategoryId($query)
    {
        return $query->groupBy($this->table . '.category_id');
    }

    /**
     * @author : dtphi .
     * @param $query
     * @param string $alias
     * @return mixed
     */
    public function scopeLjoinCategory($query, $alias = '')
    {
        if (empty($alias)) {
            $alias = Tables::tbl_categorys;
        }

        return $query->leftJoin(
            Tables::tbl_categorys . ' AS ' . $alias,
            $this->table . '.category_id',
            '=',
            $alias . '.category_id'
        );
    }

    /**
     * @author : dtphi .
     * @param $query
     * @param string $alias
     * @return mixed
     */
    public function scopeLjoinCateDescription($query, $alias = '')
    {
        if (empty($alias)) {
            $alias = Tables::tbl_category_descriptions;
        }

        return $query->leftJoin(
            Tables::tbl_category_descriptions . ' AS ' . $alias,
            $this->table . '.path_id',
            '=',
            $alias . '.category_id'
        );
    }

    /**
     * @author : dtphi .
     * @param $query
     * @param string $alias
     * @param string $name
     * @return mixed
     */
    public function scopeFilterLikeName($query, $alias = '', $name = '')
    {
        return $query->where($alias . '.name', 'LIKE', "%{$name}%");
    }
}
