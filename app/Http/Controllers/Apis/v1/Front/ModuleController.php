<?php

namespace App\Http\Controllers\Apis\Front;

use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Apis\Front\Base\ApiController as Controller;
use App\Services\Apis\Fronts\SettingPages\BasicSetting;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * @author: dtphi .
     * SettingController constructor.
     * @param newsGpSv $bsSv->settingRepository()
     * @param array $middleware
     */
    public function __construct(protected BasicSetting $settingSv, array $middleware = [])
    {
        parent::__construct($middleware);
    }

    public function showDataList(Request $request)
    {
        $params = $request->all();
        $json   = [];

        try {
            $moduleData = $this->getSettingSv()->settingRepository()->apiGetList(['code' => $params['code']]);
            $results    = [];
            foreach ($moduleData as $setting) {
                $value = ($setting->serialized) ? unserialize($setting->value) : $setting->value;

                if (!empty($value)) {
                    if (is_array($value[0])) {
                        $results[$setting->key_data] = $value;
                    } else {
                        $categories = $this->getSettingSv()->settingRepository()->apiGetCategoryByIds($value);
                        foreach ($categories as $cate) {
                            $results[$setting->key_data][] = [
                                'name' => $cate->name,
                                'href' => 'path=' . $cate->category_id,
                                'link' => $cate->name_slug
                            ];
                        }
                    }
                } else {
                    $results[$setting->key_data] = [];
                }
            }

            $json['moduleData'] = $results;

        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return response()->json($json);
    }
}
