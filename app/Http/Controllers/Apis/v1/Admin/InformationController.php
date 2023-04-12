<?php

namespace App\Http\Controllers\Apis\Admin;

use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Apis\Admin\Base\ApiController;
use App\Services\Apis\Admins\InformationPages\BasicInformation;
use App\Http\Requests\InformationRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Log;

class InformationController extends ApiController
{
    /**
     * @author: dtphi .
     * InformationController constructor.
     * @param array $middleware
     */
    public function __construct(private BasicInformation $bsSv, array $middleware = [])
    {
        $this->resourceName = INFORMATION_RESOURCE_NAME;
        $this->requestName =  INFORMATION_REQUEST_NAME;
        parent::__construct($middleware);
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return mixed
     */
    public function index(InformationRequest $request)
    {
        $repository = $this->bsSv->infoRepository();
        $data = $request->extractToFormArray();
        $page = 1;
        if ($request->query('page')) {
            $page = $request->query('page');
        }
        try {
            $limit       = $this->_getPerPage();
            $collections = $repository->apiGetList($data, $limit);

            if (isset($data['infoType']) && $data['infoType'] == 'module_special_info') {
                $pagination = [];
            } else {
                $pagination  = $this->_getTextPagination($collections);
            }

            $results = [];
            foreach ($collections as $key => $info) {
                $staticImgThum = NO_THUMB_IMG;
                $realPath = public_path($info->image['path']);
                if (file_exists($realPath) && (false !== realpath($realPath)) && !empty($info->image['path'])) {
                    $staticImgThum = $info->image['path'];
                }

                $results[] = [
                    'information_id' => (int)$info->information_id,
                    'image'          => $info->image,
                    'imgThum'        => url($this->getThumbnail($staticImgThum, 0, 40)),
                    'name'           => $info->name,
                    'status'         => $info->status,
                    'status_text'    => $info->status_text,
                    'sort_order'     => $info->sort_order,
                    'date_available' => $info->date_available,
                    'created_at'     => $info->created_at
                ];
            }
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return $this->respondWithCollectionPagination($results, $pagination, $page);
    }

    /**
     * @author : dtphi .
     * @param null $id
     * @return mixed
     */
    public function show($id = null)
    {
        $repository = $this->bsSv->infoRepository();

        try {
            $json = $repository->apiGetResourceDetail($id);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return $json;
    }

    /**
     * @author : dtphi .
     * @param InformationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(InformationRequest $request)
    {
        $storeResponse = $this->__handleStore($request);

        if ($storeResponse->getStatusCode() === Response::HTTP_BAD_REQUEST) {
            return $storeResponse;
        }

        $resourceId = ($this->getResource()) ? $this->getResource()->information_id : null;

        return $this->respondCreated("New {$this->resourceName} created.", $resourceId);
    }

    /**
     * @author : dtphi .
     * @param InformationRequest $request
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(InformationRequest $request, $id = null)
    {
        $repository = $this->bsSv->infoRepository();

        try {
            $model = $repository->apiGetDetail($id);
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
        $repository = $this->bsSv->infoRepository();

        try {
            $model = $repository->apiGetDetail($id);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        $repository->deleteInformation($model);

        return $this->respondDeleted("{$this->resourceName} deleted.");
    }

    /**
     * @author : dtphi .
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function __handleStore(&$request)
    {
        $repository = $this->bsSv->infoRepository();

        $data = $request->extractToFormArray();

        if ($result = $repository->apiInsert($data)) {
            return $this->respondUpdated($result);
        }

        return $this->respondBadRequest();
    }

    /**
     * @author : dtphi .
     * @param $model
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function __handleStoreUpdate(&$model, &$request)
    {
        $repository = $this->bsSv->infoRepository();

        $data = $request->extractToFormArray();

        if ($result = $repository->apiUpdate($model, $data)) {
            return $this->respondUpdated($result);
        }

        return $this->respondBadRequest();
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function uploadImage(InformationRequest $request)
    {
        if ($request->is('options')) {
            return;
        }

        return $this->respondBadRequest();
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return mixed
     */
    public function dropdown(InformationRequest $request)
    {
        $repository = $this->bsSv->infoRepository();

        $data = $request->extractToFormArray();

        if (isset($data['action']) && $data['action'] === 'info.album.dropdown') {
            return $this->_getAlbumDropdown($data);
        }

        $results     = $repository->apiGetList($data);
        $collections = [];

        foreach ($results as $key => $value) {
            $collections[] = [
                'information_id' => $value->information_id,
                'name'           => $value->name,
            ];
        }

        return $this->respondWithCollectionPagination($collections);
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return mixed
     */
    public function _getAlbumDropdown($data = [])
    {
        $repository = $this->bsSv->infoRepository();

        $results     = $repository->apiGetAlbumList($data);
        $collections = [];

        foreach ($results as $value) {
            $collections[] = [
                'album_id' => $value->id,
                'name'     => $value->albums_name,
            ];
        }

        return $this->respondWithCollectionPagination($collections);
    }
}
