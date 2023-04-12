<?php

namespace App\Http\Controllers\Apis\Admin;

use App\Events\SearchUserEvent;
use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Apis\Admin\Base\ApiController;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use App\Services\Apis\Admins\AdminPages\BasicAdminUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Log;

class UserController extends ApiController
{
    /**
     * @author: dtphi .
     * AdminController constructor.
     * @param BasicAdminUser $bsSv->adminRepository()
     * @param array $middleware
     */
    public function __construct(private BasicAdminUser $bsSv, array $middleware = [])
    {
        $this->resourceName = USER_RESOURCE_NAME;
        $this->requestName = USER_REQUEST_NAME;
        parent::__construct($middleware);
    }

    /**
     * @author : dtphi .
     * @param Request $request
     * @return mixed
     */
    public function index(AdminRequest $request)
    {
        $repository = $this->bsSv->adminRepository();

        try {
            $limit       = $this->_getPerPage();
            $collections = $repository->apiGetResourceCollection([], $limit);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return $this->respondWithCollectionPagination($collections->all());
    }

    /**
     * @author : dtphi .
     * @param null $id
     * @return mixed
     */
    public function show($id = null)
    {
        $repository = $this->bsSv->adminRepository();
        try {
            $json = $repository->apiGetResourceDetail($id);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return $json;
    }

    /**
     * @author : dtphi .
     * @param AdminRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AdminRequest $request)
    {

        $storeResponse = $this->__handleStore($request);

        if ($storeResponse->getStatusCode() === Response::HTTP_BAD_REQUEST) {
            return $storeResponse;
        }

        $resourceId = ($this->getResource()) ? $this->getResource()->id : null;

        return $this->respondCreated("New {$this->resourceName} created.", $resourceId);
    }

    /**
     * @author : dtphi .
     * @param AdminRequest $request
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AdminRequest $request, $id = null)
    {
        $repository = $this->bsSv->adminRepository();

        try {
            $repository->apiGetDetail($id);
        } catch (HandlerMsgCommon $e) {
            Log::debug('User not found, Request ID = ' . $id);

            throw $e->render();
        }

        return $this->__handleStore($request);
    }

    /**
     * @author : dtphi .
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id = null)
    {
        $repository = $this->bsSv->adminRepository();

        try {
            $user = $repository->apiGetDetail($id);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        $user->destroy($id);

        return $this->respondDeleted("{$this->resourceName} deleted.");
    }

    /**
     * @author : dtphi .
     * @param Admin $user
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function __handleStore(&$request)
    {
        $repository = $this->bsSv->adminRepository();
        $requestParams = $request->all();

        if (($request->get('action') == 'permission') && !empty($requestParams['userAbilities'])) {
            $result = $repository->apiPermissionUpdate($requestParams['userAbilities'], $requestParams['id']);
            return $this->respondUpdated($result);
        }

        if ($result = $repository->apiInsertOrUpdate($requestParams)) {
            return $this->respondUpdated($result);
        }

        return $this->respondBadRequest();
    }

    /**
     * @author : dtphi .
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(AdminRequest $request)
    {
        $repository = $this->bsSv->adminRepository();

        $collections = $repository->apiGetResourceCollection(['email'], 0);

        event(new SearchUserEvent($collections));

        return response()->json("ok");
    }
}
