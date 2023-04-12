<?php

namespace App\Http\Controllers\Apis\Front;

use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Apis\Front\Base\ApiController as Controller;
use App\Services\Apis\Fronts\SettingPages\BasicSetting;
use App\Services\Apis\Fronts\VideoPages\BasicVideo;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * @var string
     */
    protected $resourceName = 'video';

    /**
     * @author : dtphi .
     * VideoController constructor.
     * @param array $middleware
     */
    public function __construct(private BasicVideo $bsSv, protected BasicSetting $settingSv, array $middleware = [])
    {
        parent::__construct($middleware);
    }

    /**
     * [getServiceContext:  ]
     * @return [type] [description]
     */
    public function getServiceContext()
    {
        return $this->bsSv->videoRepository();
    }

    public function index()
    {
        $bannerPath = '/upload/home_banners';

        try {
            $pageLists = [
            ];
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return response()->json([
            'pageLists' => $pageLists
        ]);
    }
}
