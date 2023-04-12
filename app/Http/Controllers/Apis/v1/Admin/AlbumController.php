<?php

namespace App\Http\Controllers\Apis\Admin;

use Illuminate\Http\Request;
use App\Exceptions\HandlerMsgCommon;
use App\Http\Requests\AlbumsRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Apis\Admin\Base\ApiController;
use App\Services\Apis\Admins\AlbumPages\BasicAlbum;

class AlbumController extends ApiController
{
    public function __construct(private BasicAlbum $bsSv, array $middleware = [])
    {
        $this->resourceName = ALBUM_RESOURCE_NAME;
        $this->requestName = ALBUM_REQUEST_NAME;
        parent::__construct($middleware);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AlbumsRequest $request)
    {
        $repository = $this->bsSv->albumRepository();

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
                $staticImgThum = NO_THUMB_IMG;
                $realPath = public_path($info->image_origin['path']);

                if (file_exists($realPath) && (false !== realpath($realPath)) && !empty($info->image_origin['path'])) {
                    $staticImgThum = $info->image_origin['path'];
                }
                $results[] = [
                    'id' => (int)$info->id,
                    'albums_name' => $info->albums_name,
                    'status' => $info->status,
                    'sort_id' => $info->sort_id,
                    'imgThum' => url($this->getThumbnail($staticImgThum, 0, 40)),
                    'name_group_albums' => $info->groupAlbums ? $info->groupAlbums->group_name : '',
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
    public function store(AlbumsRequest $request)
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
        $repository = $this->bsSv->albumRepository();

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
        $repository = $this->bsSv->albumRepository();

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
    public function update(AlbumsRequest $request, $id = null)
    {
        $repository = $this->bsSv->albumRepository();

        try {
            $model = $repository->apiGetDetail($id);
        } catch (HandlerMsgCommon $e) {
            Log::debug('User not found, Request ID = ' . $id);

            throw $e->render();
        }

        return $this->__handleStoreUpdate($model, $request);
    }

    private function __handleStoreUpdate(&$model, &$request)
    {
        $repository = $this->bsSv->albumRepository();

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
        $repository = $this->bsSv->albumRepository();

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
        $repository = $this->bsSv->albumRepository();
        $data = $request->extractToFormArray();
        if ($result = $repository->apiChangeStatus($data)) {
            return $this->respondUpdated($result);
        }

        return $this->respondBadRequest();
    }
}
