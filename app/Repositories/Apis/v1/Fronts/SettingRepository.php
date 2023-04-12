<?php

namespace App\Repositories\Apis\Fronts;

use App\Contacts\Apis\Fronts\Repositories\Setting as SettingRepo;
use App\Models\Category;
use App\Models\Setting;
use DB;

final class SettingRepository implements SettingRepo
{
    /**
     * @var Setting|null
     */
    private $model = null;

    /**
     * [$modelNewGroup description]
     * @var null
     */
    private $modelNewGroup = null;

    /**
     * @author : dtphi .
     * SettingService constructor.
     */
    public function __construct()
    {
        $this->model         = new Setting();
        $this->modelNewGroup = new Category();
    }

    protected function categoryModel()
    {
        if (is_null($this->modelNewGroup)) {
            $this->modelNewGroup = new Category();
        }

        return $this->modelNewGroup;
    }

    public function apiGetList(array $options = [], $limit = 15)
    {
        $query = $this->model->filterCode($options['code']);

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    public function apiGetCategoryByIds($ids = [])
    {
        $query = $this->categoryModel()->select()
            ->lfJoinDescription()
            ->filterInByIds($ids)
            ->filterActiveStatus()
            ->orderByAscSort()
            ->orderByAscParentId();

        return $query->get();
    }

    public function apiGetDetail($id = null)
    {
        $this->model = $this->model->filterKey($id)->get();

        return $this->model;
    }

    public function apiGetSettingByCodes($code = '')
    {
        $query = $this->model->filterCode($code);

        return $query->get();
    }
}
