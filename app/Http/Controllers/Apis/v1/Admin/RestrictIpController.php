<?php

namespace App\Http\Controllers\Apis\Admin;

use Log;
use Illuminate\Http\Request;
use App\Exceptions\HandlerMsgCommon;
use App\Http\Requests\RestrictIpRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Apis\Admin\Base\ApiController;
use App\Services\Apis\Admins\RestrictIpPages\BasicRestrictIp;

class RestrictIpController extends ApiController
{
    public function __construct(private BasicRestrictIp $bsSv, array $middleware = [])
    {
        $this->resourceName = RESTRICT_IP_RESOURCE_NAME;
        $this->requestName = RESTRICT_IP_REQUEST_NAME;
        parent::__construct($middleware);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RestrictIpRequest $request)
    {
        $repository = $this->bsSv->resIpRepository();

        $data = $request->extractToFormArray();
        $page = 1;
        if ($request->query('page')) {
            $page = (int)$request->query('page');
        }
        try {
            $limit       = $this->_getPerPage();
            $collections = $repository->apiGetList($data, $limit);
            $pagination  = $this->_getTextPagination($collections);
            $results = [];
            foreach ($collections as $key => $info) {
                $results[] = [
                    'id' => (int)$info->id,
                    'ip' => $info->ip,
                    'active' => $info->active,
                ];
            }
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return $this->respondWithCollectionPagination($results, $pagination, $page);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RestrictIpRequest $request)
    {
        $storeResponse = $this->__handleStore($request);
        if ($storeResponse->getStatusCode() === Response::HTTP_BAD_REQUEST) {
            return $storeResponse;
        }

        $resourceId = ($this->getResource()) ? $this->getResource()->id : null;

        return $this->respondCreated("New {$this->resourceName} created.", $resourceId);
    }

    private function __handleStore(&$request)
    {
        $repository = $this->bsSv->resIpRepository();

        $data = $request->extractToFormArray();
        if ($result = $repository->apiInsert($data)) {
            return $this->respondUpdated($result);
        }
        return $this->respondBadRequest();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
    {
        $repository = $this->bsSv->resIpRepository();

        try {
            $json = $repository->apiGetResourceDetail($id);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }
        return $json;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RestrictIpRequest $request, $id)
    {
        $repository = $this->bsSv->resIpRepository();

        try {
            $model = $repository->apiGetDetail($id);
        } catch (HandlerMsgCommon $e) {
            Log::debug('Restrict ip not found, Request ID = ' . $id);
            throw $e->render();
        }
        return $this->__handleStoreUpdate($model, $request);
    }

    private function __handleStoreUpdate(&$model, &$request)
    {
        $repository = $this->bsSv->resIpRepository();

        $data = $request->extractToFormArray();
        if ($result = $repository->apiUpdate($model, $data)) {
            return $this->respondUpdated($result);
        }

        return $this->respondBadRequest();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $repository = $this->bsSv->resIpRepository();

        try {
            $model = $repository->apiGetDetail($id);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }
        $repository->apiDelete($model);
        return $this->respondDeleted("{$this->resourceName} deleted.");
    }

    public function search(RestrictIpRequest $request)
    {
        $repository = $this->bsSv->resIpRepository();

        $data = $request->extractToFormArray();
        $page = 1;
        if ($request->query('page')) {
            $page = (int)$request->query('page');
        }
        if ($request->query('query')) {
            $query = $request->query('query');
        }
        try {
            $limit       = $this->_getPerPage();
            $collections = $repository->apiGetSearch($data, $limit, $query);
            $pagination  = $this->_getTextPagination($collections);
            $results = [];
            foreach ($collections as $key => $info) {
                $results[] = [
                    'id' => (int)$info->id,
                    'ip' => $info->ip,
                    'active' => $info->active,
                ];
            }
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return $this->respondWithCollectionPagination($results, $pagination, $page);
    }

    public function changeStatus(Request $request)
    {
        $repository = $this->bsSv->resIpRepository();

        $data = $request->extractToFormArray();
        if ($result = $repository->apiChangeStatus($data)) {
            return $this->respondUpdated($result);
        }
        return $this->respondBadRequest();
    }
}
