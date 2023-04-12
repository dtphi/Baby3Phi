<?php

namespace App\Http\Controllers\Apis\Admin;

use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Apis\Admin\Base\ApiController;
use App\Services\Apis\Admins\GroupAlbumPages\BasicGroupAlbum;
use App\Http\Requests\GroupAlbumsRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Log;

class GroupAlbumController extends ApiController
{
    public function __construct(private BasicGroupAlbum $bsSv, array $middleware = [])
    {
        $this->resourceName = ALBUM_CATEGORY_RESOURCE_NAME;
        $this->requestName = ALBUM_CATEGORY_REQUEST_NAME;
        parent::__construct($middleware);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GroupAlbumsRequest $request)
    {
        $repository = $this->bsSv->groupAlbumRepository();

        $data = $request->extractToFormArray();
        $page = 1;
        if ($request->query('page')) {
            $page = $request->query('page');
        }
        try {
            $limit       = $this->_getPerPage();
            $collections = $repository->apiGetList($data, $limit);
            $pagination  = $this->_getTextPagination($collections);
            $results = [];

            foreach ($collections as $key => $info) {
                $results[] = [
                    'id'         => (int)$info->id,
                    'group_name' => $info->group_name,
                    'status'     => $info->status,
                    'sort_id'    => $info->sort_id,
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
    public function store(GroupAlbumsRequest $request)
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
        $repository = $this->bsSv->groupAlbumRepository();

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
        $repository = $this->bsSv->groupAlbumRepository();

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
    public function update(GroupAlbumsRequest $request, $id)
    {
        $repository = $this->bsSv->groupAlbumRepository();

        try {
            $model = $repository->apiGetDetail($id);
        } catch (HandlerMsgCommon $e) {
            Log::debug('Group_albums ip not found, Request ID = ' . $id);
            throw $e->render();
        }
        return $this->__handleStoreUpdate($model, $request);
    }

    private function __handleStoreUpdate(&$model, &$request)
    {
        $repository = $this->bsSv->groupAlbumRepository();

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
        $repository = $this->bsSv->groupAlbumRepository();

        try {
            $model = $repository->apiGetDetail($id);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }
        $repository->apiDelete($model);
        return $this->respondDeleted("{$this->resourceName} deleted.");
    }

    public function changeStatus(Request $request)
    {
        $repository = $this->bsSv->groupAlbumRepository();

        $formData = $request->all();
        if ($result = $repository->apiChangeStatus($formData)) {
            return $this->respondUpdated($result);
        }
        return $this->respondBadRequest();
    }
}
