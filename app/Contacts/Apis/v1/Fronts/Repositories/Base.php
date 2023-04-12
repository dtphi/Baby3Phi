<?php

namespace App\Contacts\Apis\Fronts\Repositories;

interface Base
{
    /**
     * @author : dtphi .
     * @param array $options
     * @param int $limit
     * @return mixed
     */
    public function apiGetList(array $options = [], $limit = 15);

    /**
     * @author : dtphi .
     * @param array $options
     * @param int $limit
     * @return mixed
     */
    public function apiGetResourceCollection(array $options = [], $limit = 15);

    public function apiGetInformationCategoryTrees();

    public function getMenuCategories($parentId = 0);

    public function apiGetCategoryById($categoryId = 0);

    public function apiGetMenuCategoryIds($parentId = 0);

    public function getMenuCategoriesToLayout($layoutId = 1);
}
