<?php

namespace App\Http\Controllers\Apis\Admin;

use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Apis\Admin\Base\ApiController;
use App\Services\Apis\Admins\SettingPages\BasicSetting;
use App\Http\Requests\SettingRequest;
use Illuminate\Http\Response;
use Log;

class SettingController extends ApiController
{
    /**
     * @author: dtphi .
     * SettingController constructor.
     * @param array $middleware
     */
    public function __construct(private BasicSetting $bsSv, array $middleware = [])
    {
        $this->resourceName = SETTING_RESOURCE_NAME;
        $this->requestName = SETTING_REQUEST_NAME;
        parent::__construct($middleware);
    }

    /**
     * @author : dtphi .
     * @param null $id
     * @return mixed
     */
    public function show($code = null)
    {
        $repository = $this->bsSv->settingRepository();

        try {
            $json = $repository->apiGetResourceCollection(['code' => $code]);
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return $json;
    }

    /**
     * @author : dtphi .
     * @param SettingRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SettingRequest $request)
    {

        $storeResponse = $this->__handleStore($request);

        if ($storeResponse->getStatusCode() === Response::HTTP_BAD_REQUEST) {
            return $storeResponse;
        }

        $resourceId = ($this->getResource()) ? $this->getResource() : null;

        return $this->respondCreated("New {$this->resourceName} created.", $resourceId);
    }

    /**
     * @author : dtphi .
     * @param Setting $setting
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function __handleStore(&$request)
    {
        $repository = $this->bsSv->settingRepository();

        $data = $request->extractToFormArray();
        if ($result = $repository->apiInsertOrUpdate($data)) {
            return $this->respondUpdated($result);
        }

        return $this->respondBadRequest();
    }
}
