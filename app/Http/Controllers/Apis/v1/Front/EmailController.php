<?php

namespace App\Http\Controllers\Apis\Front;

use Illuminate\Http\Request;
use App\Http\Requests\EmailSubscribeRequest;
use App\Http\Controllers\Apis\Front\Base\ApiController as Controller;
use App\Services\Apis\Fronts\EmailSubscribes\BasicEmailSubscribe;
use App\Services\Apis\Fronts\SettingPages\BasicSetting;
use Illuminate\Http\Response as HttpResponse;

class EmailController extends Controller
{

  public function __construct(protected BasicSetting $settingSv, private BasicEmailSubscribe $newEmailSub, array $middleware = [])
  {
      parent::__construct($middleware);
  }

  public function store(EmailSubscribeRequest $request)
  {
    $storeResponse = $this->__handleStore($request);

    if ($storeResponse->getStatusCode() === HttpResponse::HTTP_BAD_REQUEST) {
      return $storeResponse;
    }

    return response()->json('success');
  }

  private function __handleStore(&$request)
  {
    $requestParams = $request->all();

    if ($this->newEmailSub->apiInsert($requestParams)) {
      return response()->json('OK!!');
    }

    return response()->json('failed!!');
  }
}
