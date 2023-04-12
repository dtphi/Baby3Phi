<?php

namespace App\Http\Controllers\Apis\Front;

use App\AppGlobals\ModuleConstants;
use App\Exceptions\HandlerMsgCommon;
use App\Http\Controllers\Apis\Front\Base\ApiController as Controller;
use App\Services\Apis\Fronts\HomePages\BasicHome;
use App\Services\Apis\Fronts\SettingPages\BasicSetting;
use App\Http\Common\Tables;
use App\Services\Apis\Fronts\BasicService;
use Illuminate\Http\Request;
use Str;
use Log;

class HomeController extends Controller
{
    /**
     * @var string
     */
    protected $resourceName = 'home';

    /**
     * @author : dtphi .
     * HomeController constructor.
     * @param array $middleware
     */
    public function __construct(protected BasicService $sv, private BasicHome $bsSv, protected BasicSetting $settingSv, array $middleware = [])
    {
        parent::__construct($middleware);
    }

    /**
     * [getServiceContext:  ]
     * @return [type] [description]
     */
    public function getRepoContext()
    {
        return $this->bsSv->homeRepository();
    }

    public function index()
    {
        try {
            $data = [];
            $settings = $this->getSettingRepo()->apiGetSettingByCodes(ModuleConstants::MODULE_BANNER_CODE);
            if ($settings) {
                foreach ($settings as $key => $setting) {
                    $values = ($setting->serialized) ? unserialize($setting->value) : $setting->value;
                    $imgThumUrl = $this->getThumbnail(!empty($values['image']) ? $values['image'] : NO_FRONT_THUMB_IMG, 273, 170);

                    $data[] = [
                        'sort' => isset($values['sort']) ? (int)$values['sort'] : $key,
                        'img' => $values['image'],
                        'imgThumbUrl' => url($imgThumUrl),
                        'url' => $values['url'],
                        'title' => Str::upper($values['title'])
                    ];
                }
            }
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return response()->json([
            'pageLists' => $data
        ]);
    }

    /**
     * Get config app.
     */
    public function getSetting(Request $request)
    {
        $requestParams = $request->get('params');

        $pathName = isset($requestParams['pathName']) ? $requestParams['pathName'] : 'home';
        $pathName = trim($pathName, '/');

        try {
            $menus      = [];
            $categories = $this->getBaseRepo()->getMenuCategories(0);

            foreach ($categories as $cate) {
                // Level 2
                $children_data_2 = array();

                if (!empty($cate->name)) {
                    $children_2 = $this->getBaseRepo()->getMenuCategories($cate->category_id);

                    foreach ($children_2 as $child_2) {
                        $path_2 = 'path=' . $cate->category_id . '_' . $child_2->category_id;
                        $link_2 = $cate->name_slug . '/' . $child_2->name_slug;
                        // Level 3
                        $children_data_3 = array();

                        if (!empty($child_2->name)) {
                            $children_3 = $this->getBaseRepo()->getMenuCategories($child_2->category_id);

                            foreach ($children_3 as $child_3) {
                                $path_3 = $path_2 . '_' . $child_3->category_id;
                                $link_3 = $link_2 . '/' . $child_3->name_slug;
                                // Level 4
                                $children_data_4 = array();

                                $children_4 = $this->getBaseRepo()->getMenuCategories($child_3->category_id);

                                foreach ($children_4 as $child_4) {
                                    $path_4 = $path_3 . '_' . $child_4->category_id;
                                    $link_4 = $link_3 . '/' . $child_4->name_slug;
                                    // Level 5
                                    $children_data_5 = array();

                                    $children_5 = $this->getBaseRepo()->getMenuCategories($child_4->category_id);

                                    foreach ($children_5 as $child_5) {
                                        $path_5 = $path_4 . '_' . $child_5->category_id;
                                        $link_5 = $link_4 . '/' . $child_5->name_slug;

                                        // Level 5-1
                                        $filter_data = array(
                                            'filter_category_id'  => $child_5->category_id,
                                            'filter_sub_category' => true
                                        );

                                        $children_data_5[] = array(
                                            'name' => $child_5->name,
                                            'href' => $path_5,
                                            'link' => $link_5
                                        );
                                    }

                                    // Level 4 - 1
                                    $filter_data = array(
                                        'filter_category_id'  => $child_4->category_id,
                                        'filter_sub_category' => true
                                    );

                                    $children_data_4[] = array(
                                        'name'     => $child_4->name,
                                        'children' => $children_data_5,
                                        'href'     => $path_4,
                                        'link'     => $link_4
                                    );
                                }

                                // Level 3 -1
                                $filter_data = array(
                                    'filter_category_id'  => $child_3->category_id,
                                    'filter_sub_category' => true
                                );

                                $children_data_3[] = array(
                                    'name'     => $child_3->name,
                                    'children' => $children_data_4,
                                    'href'     => $path_3,
                                    'link'     => $link_3
                                );
                            }
                        }

                        // Level 2 - 1
                        $filter_data = array(
                            'filter_category_id'  => $child_2->category_id,
                            'filter_sub_category' => true
                        );

                        $children_data_2[] = array(
                            'name'     => $child_2->name,
                            'children' => $children_data_3,
                            'href'     => $path_2,
                            'link'     => $link_2
                        );
                    }
                }

                // Level 1
                $menus[] = array(
                    'name'     => $cate->name,
                    'children' => $children_data_2,
                    'href'     => 'path=' . $cate->category_id,
                    'link'     => $cate->name_slug
                );
            }

            $menuLayout_1 = [];

            $appImgPath      = '/upload/app';
            $data['appList'] = [
                [
                    'sort'         => 0,
                    'title'        => 'App website gppc',
                    'img'          => $appImgPath . '/app_website_gppc.png',
                    'hrefAppStore' => '/',
                    'hrefChPlay'   => '/'
                ],
                [
                    'sort'         => 1,
                    'title'        => 'App sách nói công giáo',
                    'img'          => $appImgPath . '/app_sach_noi_cong_giao.jpg',
                    'hrefAppStore' => '/',
                    'hrefChPlay'   => '/'
                ],
                [
                    'sort'         => 2,
                    'title'        => 'App tìm nhà thờ gần nhất',
                    'img'          => $appImgPath . '/app_tim_nha_tho.jpg',
                    'hrefAppStore' => 'https://apps.apple.com/us/app/tìm-nhà-thờ-gần-nhất/id1485257114?ls=1',
                    'hrefChPlay'   => 'https://play.google.com/store/apps/details?id=com.phucuong.churchfinder&hl=en_AU&gl=US'
                ],
            ];
            $settings = $this->getSettingRepo()->apiGetSettingByCodes([
                ModuleConstants::MODULE_SYSTEM_CODE
            ]);
            $systems = [];
            if ($settings) {
                $systems = $settings->reduce(function ($carry, $item) {
                    $value = '';

                    switch ($item->serialized) {
                        case 1:
                            $value = unserialize($item->value);
                            break;

                        case 2:
                            $value = json_decode($item->value);
                            break;

                        default:
                            $value = $item->value;
                            break;
                    }

                    $carry[$item->key_data] = $value;

                    return $carry;
                });
            }

            $data['banner']  = isset($systems['module_system_banners']) ? url($systems['module_system_banners']['image']) : url('Image/NewPicture/home_banners/banner_image.png');
            $data['logo'] = isset($systems['module_system_logos']) ? url($systems['module_system_logos']) : url('/front/img/logo.png');
            $data['phone'] = isset($systems['module_system_phones']) ? $systems['module_system_phones'] : '';
            $data['phoneBgColor'] = isset($systems['module_system_content_backgd_phones']) ? $systems['module_system_content_backgd_phones'] : '#3aacda';
            $data['email'] = isset($systems['module_system_emails']) ? $systems['module_system_emails'] : '';
            $data['headerTitle'] = isset($systems['module_system_header_titles']) ? $systems['module_system_header_titles'] : '';
            $data['headerBgColor'] = isset($systems['module_system_content_backgd_header_titles']) ? $systems['module_system_content_backgd_header_titles'] : '#0071bc';
            $data['logoTitle'] = isset($systems['module_system_logo_titles']) ? $systems['module_system_logo_titles'] : '';
            $data['logoTitle1'] = isset($systems['module_system_logo_title_1s']) ? $systems['module_system_logo_title_1s'] : '';
            $data['logoBgColor'] = isset($systems['module_system_content_backgd_logos']) ? $systems['module_system_content_backgd_logos'] : '#2354a4';
            $data['contentBgColor'] = isset($systems['module_system_con_background_colors']) ? $systems['module_system_con_background_colors'] : 'rgba(128, 128, 128, 0.07)';

            $data['menus']   = $menus;
            $data['menus_1'] = $menuLayout_1;

            $data['modules'] = $this->_getModules($request);

            $data['pages'] = [
                'home'  => [
                    'title' => 'Trang chủ',
                    'id'    => 1,
                ],
                'video' => [
                    'title' => 'Trang video',
                    'id'    => 2
                ],
                'news'  => [
                    'title' => 'Trang tin tức',
                    'id'    => 3
                ]
            ];

            $data['infoLasteds']  = $this->getLastedInfoList($request);
            $data['infoPopulars'] = $this->getPopularList($request);
            $data['lastAlbum'] = $this->getLastImageListAlbums();
        } catch (HandlerMsgCommon $e) {
            throw $e->render();
        }

        return response()->json($data);
    }
}
