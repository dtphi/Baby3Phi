<?php

namespace App\Http\Controllers\Apis\Admin;

use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Apis\Admin\Base\ApiController;
use App\Services\Apis\Admins\InformationCategoryPages\BasicInformationCategory;
use App\Http\Requests\InformationCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Log;

/**
 * Class InformationCategoryController
 *
 * @package App\Http\Controllers\Api\Admin
 */
class InformationCategoryController extends ApiController
{
    /**
     * @author: dtphi .
     * InformationCategoryController constructor.
     * @param array $middleware
     */
    public function __construct(private BasicInformationCategory $bsSv, array $middleware = [])
    {
        $this->resourceName = INFORMATION_CATEGORY_RESOURCE_NAME;
        $this->requestName =  INFORMATION_CATEGORY_REQUEST_NAME;
        parent::__construct($middleware);
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(InformationCategoryRequest $request)
    {
        $repository = $this->bsSv->groupInfoRepository();

        $data = $request->extractToFormArray();
        $page = 1;
        if ($request->query('page')) {
            $page = $request->query('page');
        }
        $data['page'] = $page;

        try {
            $limit      = $this->_getPerPage();
            $newsGroups = $repository->apiGetList($data, $limit);
            $pagination = $this->_getTextPagination($newsGroups);

            $results = [];
            foreach ($newsGroups as $key => $newsGroup) {
                $results[] = [
                    'category_name' => $newsGroup->category_name,
                    'sort_order'    => $newsGroup->sort_order,
                    'category_id'   => $newsGroup->category_id
                ];
            }
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return $this->respondWithCollectionPagination($results, $pagination, $page);
    }

    /**
     * @author : dtphi .
     * @param LengthAwarePaginator $paginator
     * @return array
     */
    protected function _getTextPagination(LengthAwarePaginator $paginator)
    {
        $data = [];

        if ($paginator instanceof LengthAwarePaginator && $paginator->count()) {
            $data = $paginator->toArray();

            unset($data['data']);
        }

        return $data;
    }

    /**
     * @author : dtphi .
     * @param $data
     * @param int $parent
     * @param int $depth
     * @return array
     */
    public function generateTree($data, $parent = -1, $depth = 0)
    {
        $newsGroupTree = [];

        for ($i = 0, $ni = count($data); $i < $ni; $i++) {
            if ($data[$i]['father_id'] == $parent) {
                $newsGroupTree[$data[$i]['id']]['id']            = $data[$i]['id'];
                $newsGroupTree[$data[$i]['id']]['fatherId']      = $data[$i]['father_id'];
                $newsGroupTree[$data[$i]['id']]['newsgroupname'] = $data[$i]['newsgroupname'];
                $newsGroupTree[$data[$i]['id']]['children']      = $this->generateTree(
                    $data,
                    $data[$i]['id'],
                    $depth + 1
                );
            }
        }

        return $newsGroupTree;
    }

    /**
     * @author : dtphi .
     * @param null $id
     * @return mixed
     */
    public function show($id = null)
    {
        $repository = $this->bsSv->groupInfoRepository();

        $json = [];

        try {
            if ($id) {
                $json = $repository->apiGetResourceDetail($id);
            }
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return $json;
    }

    /**
     * @author : dtphi .
     * @param InformationCategoryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(InformationCategoryRequest $request)
    {
        $storeResponse = $this->__handleStore($request);

        if ($storeResponse->getStatusCode() === Response::HTTP_BAD_REQUEST) {
            return $storeResponse;
        }

        $resourceId = ($this->getResource()) ? $this->getResource()->category_id : null;

        return $this->respondCreated("New {$this->resourceName} created.", $resourceId);
    }

    /**
     * @author : dtphi .
     * @param InformationCategoryRequest $request
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(InformationCategoryRequest $request, $id = null)
    {
        $repository = $this->bsSv->groupInfoRepository();

        $model = null;

        try {
            if ($id) {
                $model = $repository->getCateogryById($id);
            }
        } catch (HandlerMsgCommon $e) {
            Log::debug('User not found, Request ID = ' . $id);

            throw $e->render();
        }

        return $this->__handleStoreUpdate($model, $request);
    }

    /**
     * @author : dtphi .
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id = null)
    {
        $repository = $this->bsSv->groupInfoRepository();

        try {
            $model = $repository->getCateogryById($id);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        $repository->deleteCategory($model);

        return $this->respondDeleted("{$this->resourceName} deleted.");
    }

    /**
     * @author : dtphi .
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function __handleStore(&$request)
    {
        $repository = $this->bsSv->groupInfoRepository();

        $data = $request->extractToFormArray();

        if ($result = $repository->apiInsert($data)) {
            return $this->respondUpdated($result);
        }

        return $this->respondBadRequest();
    }

    /**
     * @author : dtphi .
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function __handleStoreUpdate(&$model, &$request)
    {
        $repository = $this->bsSv->groupInfoRepository();

        $data = $request->extractToFormArray();

        if (!is_null($model)) {
            if ($result = $repository->apiUpdate($model, $data)) {
                return $this->respondUpdated($result);
            }
        }

        return $this->respondBadRequest();
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return mixed
     */
    public function dropdown(InformationCategoryRequest $request)
    {
        $repository = $this->bsSv->groupInfoRepository();

        $data = $request->extractToFormArray();

        $results     = $repository->apiGetCategories($data, 0);
        $collections = [];

        foreach ($results as $key => $value) {
            $collections[] = [
                'category_id' => $value->category_id,
                'name'        => strip_tags(html_entity_decode($value->name, ENT_QUOTES, 'UTF-8')),
            ];
        }

        return $this->respondWithCollectionPagination($collections);
    }
}
