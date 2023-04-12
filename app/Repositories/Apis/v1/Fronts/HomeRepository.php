<?php

namespace App\Repositories\Apis\Fronts;

use App\Contacts\Apis\Fronts\Repositories\Home as HomeRepo;
use App\Models\Category;
use App\Models\Information;
use DB;

final class HomeRepository implements HomeRepo
{
    /**
     * [$modelNewGroup description]
     * @var null
     */
    private $modelNewGroup = null;

    /**
     * @var Admin|null
     */
    private $model = null;


    /**
     * @author : dtphi .
     * AdminService constructor.
     */
    public function __construct()
    {
        $this->model         = new Information();
        $this->modelNewGroup = new Category();
    }

    protected function infoModel()
    {
        if (is_null($this->modelInfo)) {
            $this->modelInfo = new Information();
        }

        return $this->modelInfo;
    }

    protected function categoryModel()
    {
        if (is_null($this->modelNewGroup)) {
            $this->modelNewGroup = new Category();
        }

        return $this->modelNewGroup;
    }

    public function getMenuCategories($parentId = 0)
    {
        $query = $this->categoryModel()->select()
            ->lfJoinDescription()
            ->filterParentId($parentId)
            ->filterActiveStatus()
            ->orderByAscSort()
            ->orderByAscParentId();

        return $query->get();
    }
}
