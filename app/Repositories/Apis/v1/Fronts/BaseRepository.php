<?php

namespace App\Repositories\Apis\Fronts;

use App\Contacts\Apis\Fronts\Repositories\Base as BaseRepo;
use App\Models\Category;
use App\Http\Common\Tables;
use App\Models\Information;
use DB;

final class BaseRepository implements BaseRepo
{
    /**
	 * [$modelNewGroup description]
	 * @var null
	 */
	private $modelNewGroup = null;

	/**
	 * @author : dtphi .
	 * AdminService constructor.
	 */
	public function __construct()
	{
		$this->modelInfo     = new Information();
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

	/**
	 * @author: dtphi .
	 * @param array $options
	 * @param int $limit
	 * @return AdminCollection
	 */
	public function apiGetList(array $options = [], $limit = 15)
	{
	}

	/**
	 * author : dtphi .
	 * @param array $options
	 * @param int $limit
	 * @return InformationCollection
	 */
	public function apiGetResourceCollection(array $options = [], $limit = 15)
	{
		// TODO: Implement apiGetResourceCollection() method.
	}

	/**
	 * @author : dtphi .
	 * @return array
	 */
	public function apiGetInformationCategoryTrees()
	{
		// TODO: Implement apiGetInformationCategoryTrees() method.
		$query = $this->categoryModel()
			->select('id', 'father_id', 'newsgroupname', 'displays', 'sort')
			->orderBySortAsc();

		return [
			'total' => $query->count(),
			'data'  => $query->get()->toArray()
		];
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

	public function apiGetCategoryById($categoryId = 0)
	{
		$query = $this->categoryModel()->select()
			->lfJoinDescription()
			->filterById($categoryId)
			->filterActiveStatus();

		return $query->first();
	}

	public function apiGetMenuCategoryIds($parentId = 0)
	{
		$query = DB::table('pc_categorys')->select('category_id')
			->where('pc_categorys.parent_id', (int)$parentId)
			->where('pc_categorys.status', '1');

		return $query->get()->toArray();
	}

	public function getMenuCategoriesToLayout($layoutId = 1)
	{
		$query = $this->categoryModel()->select()
			->lfJoinDescription()
			->lfJoinToLayout()
			->filterLayoutId($layoutId)
			->filterActiveStatus()
			->orderByAscSort()
			->orderByAscParentId();

		return $query->get();
	}
}
