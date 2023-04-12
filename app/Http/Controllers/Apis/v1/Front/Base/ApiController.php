<?php

namespace App\Http\Controllers\Apis\Front\Base;

use Image;
use Storage;
use Illuminate\Http\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Albums;
use Log;

class ApiController extends Controller
{
    public static $thumSize = 200;

    public static $menuFullInfos = [63, 205, 207, 208, 209, 210, 211, 213, 214, 216, 220, 241, 248, 273];

    public static $tmbThumbDir = '.tmb';

    public static $disk = 'public';

    // Success
    const RESPONSE_OK = 2000;
    const RESPONSE_CREATED = 2001;
    const RESPONSE_UPDATED = 2002;
    const RESPONSE_DELETED = 2003;
    const RESPONSE_IN_PROGRESS = 2004;

    public function getThumbnail($imgOrigin, $thumbSize = 0, $thumbHeight = 0, $force = false)
    {
        $imgThumUrl = '';
        if ($thumbSize <= 0) {
            $thumbSize = self::$thumSize;
        }

        $staticThumImg = rawurldecode(trim($imgOrigin, '/'));
        if (!file_exists(public_path('/' . $staticThumImg))) {
            $staticThumImg = trim(NO_FRONT_THUMB_IMG, '/');
        }

        if ($force) {
            return $this->forceThumbnail($staticThumImg, $thumbSize, $thumbHeight);
        }

        if ((int)$thumbHeight > 0) {
            $thumbDir = self::$tmbThumbDir . '/thumb_' . $thumbSize . 'x' . $thumbHeight . '/' . $staticThumImg;
            if (file_exists(public_path('/' . 'storage/' . $thumbDir))) {
                return Storage::url($thumbDir);
            }

            return $this->forceThumbnail($staticThumImg, $thumbSize, $thumbHeight);
        } else {
            $thumbDir = self::$tmbThumbDir . '/' . $staticThumImg;
            if (file_exists(public_path('/' . 'storage/' . $thumbDir))) {
                return Storage::url($thumbDir);
            }

            return $this->forceThumbnail($staticThumImg, $thumbSize);
        }
    }

    public function forceThumbnail($staticThumImg, $thumbSize = 200, $thumbHeight = 0)
    {
        $fileResize = new File(public_path($staticThumImg));
        $extension  = $fileResize->extension();
        $thumbDir   = self::$tmbThumbDir . '/' . $staticThumImg;
        if ((int)$thumbHeight > 0) {
            $thumbDir = self::$tmbThumbDir . '/thumb_' . $thumbSize . 'x' . $thumbHeight . '/' . $staticThumImg;
            $resize   = Image::make($fileResize)->resize($thumbSize, $thumbHeight)->encode($extension);
        } else {
            $resize = Image::make($fileResize)->resize($thumbSize, null, function ($constraint) {
                $constraint->aspectRatio();
            })->encode($extension);
        }

        Storage::disk(self::$disk)->put($thumbDir, $resize->__toString());

        return Storage::url($thumbDir);
    }

    public function getSv()
    {
        if (property_exists($this,'sv')) {
            return $this->sv ?? null;
        }

        return null;
    }

    public function getBaseRepo()
    {
        return $this->getSv() ? $this->getSv()->baseRepository() : null;
    }

    public function getSettingSv()
    {
        if (property_exists($this,'settingSv')) {
            return $this->settingSv ?? null;
        }

        return null;
    }

    public function getSettingRepo()
    {
        return $this->getSettingSv() ? $this->getSettingSv()->settingRepository() : null;
    }

    public function getLastImageListAlbums()
    {
        $lastAlbum = Albums::where('status', 1)->orderByDesc('id')->first();
        $value = ($lastAlbum) ? $lastAlbum->image : '';

        $value = !empty($value) ? unserialize($value) : [];
        if (!empty($value)) {
            $sort = array_column($value, 'width');
            array_multisort($sort, SORT_ASC, $value);
        }

        $albums = [];
        if (!empty($value)) {
            foreach ($value as $key => $img) {
                if ($img['status']) {
                    $tmp = $img;
                    $tmp['width'] = (int)$img['width'];
                    $tmp['image'] = url('/Image/NewPicture/' . $img['image']);
                    $tmp['image_thumb'] = url($this->getThumbnail('/Image/NewPicture/' . $img['image'], 280, 280));
                    $albums[$key] = $tmp;
                } else {
                    unset($value[$key]);
                }
            }
        }

        return $albums;
    }

    protected function _getModules(&$request)
    {
        $layout  = json_decode($request->get('layout'));
        $page    = isset($layout->page) ? $layout->page : 'home';
        $modules = [
            'module_noi_bat',
            'module_thong_bao',
            'module_category_left_side_bar',
            'module_special_info',
            'module_category_icon_side_bar'
        ];

        $results = [];

        foreach ($modules as $module) {
            $moduleData       = $this->getSettingRepo()->apiGetList(['code' => $module]);
            $results[$module] = [];

            foreach ($moduleData as $setting) {
                $value = ($setting->serialized) ? unserialize($setting->value) : $setting->value;

                if (!empty($value)) {
                    if (is_array($value[0])) {
                        $results[$module][$setting->key_data] = $value;
                    } else {
                        $categories = $this->getSettingRepo()->apiGetCategoryByIds($value);
                        foreach ($categories as $cate) {
                            $results[$module][$setting->key_data][] = [
                                'name' => $cate->name,
                                'href' => 'path=' . $cate->category_id,
                                'link' => $cate->name_slug
                            ];
                        }
                    }
                } else {
                    $results[$module][$setting->key_data] = [];
                }
            }
        }

        return $results;
    }

    public function getLastedInfoList(Request $request)
    {
        $json = [];

        $list = $this->getBaseRepo()->apiGetLatestInfos(20)->toArray();

        if (!empty($list)) {
            $infoIds = array_reduce($list, function ($carry, $item) {
                $carry[] = $item['information_id'];

                return $carry;
            });

            if (!empty($infoIds)) {
                $params                    = $request->all();
                $params['information_ids'] = $infoIds;

                $results = $this->getBaseRepo()->apiGetInfoListByIds($params);

                $json = [];
                foreach ($results as $info) {
                    $sortDes = html_entity_decode($info->sort_description);

                    $json[] = [
                        'date_available'   => date_format(date_create($info->date_available), "d-m-Y"),
                        'description'      => html_entity_decode($info->sort_description),
                        'sort_description' => Str::substr($sortDes, 0, 100),
                        'information_id'   => $info->information_id,
                        'name'             => $info->name,
                        'name_slug'        => $info->name_slug,
                        'sort_name'        => Str::substr($info->name, 0, 28),
                        'viewed'           => $info->viewed,
                        'vote'             => $info->vote,
                        'tag'              => (!empty($info->tag)) ? explode(',', $info->tag) : []
                    ];
                }
            }
        }

        return $json;
    }

    public function getPopularList(Request $request)
    {
        $json = [];

        if (!empty($request->query('slug'))) {
            return $this->list($request);
        }

        $list = $this->getBaseRepo()->apiGetPopularInfos(20)->toArray();

        if (!empty($list)) {
            $infoIds = array_reduce($list, function ($carry, $item) {
                $carry[] = $item['information_id'];

                return $carry;
            });

            if (!empty($infoIds)) {
                $params                    = $request->all();
                $params['information_ids'] = $infoIds;

                $results = $this->getBaseRepo()->apiGetInfoListByIds($params);

                $json = [];
                foreach ($results as $info) {
                    $sortDes = html_entity_decode($info->sort_description);

                    $json[] = [
                        'date_available'   => date_format(date_create($info->date_available), "d-m-Y"),
                        'description'      => html_entity_decode($info->sort_description),
                        'sort_description' => Str::substr($sortDes, 0, 100),
                        'information_id'   => $info->information_id,
                        'name'             => $info->name,
                        'name_slug'        => $info->name_slug,
                        'sort_name'        => Str::substr($info->name, 0, 25),
                        'viewed'           => $info->viewed,
                        'vote'             => $info->vote
                    ];
                }
            }
        }

        return $json;
    }

    /**
     * @author : dtphi .
     * @param $data
     * @param int $parent
     * @param int $depth
     * @return array
     */
    protected function generateTree($data, $parent = -1, $depth = 0)
    {
        $newsGroupTree = [];

        for ($i = 0, $ni = count($data); $i < $ni; $i++) {
            if ($data[$i]['father_id'] == $parent) {
                $newsGroupTree[$data[$i]['id']]['id']            = $data[$i]['id'];
                $newsGroupTree[$data[$i]['id']]['fatherId']      = $data[$i]['father_id'];
                $newsGroupTree[$data[$i]['id']]['newsgroupname'] = $data[$i]['newsgroupname'];

                $newsGroupTree[$data[$i]['id']]['children'] = $this->generateTree(
                    $data,
                    $data[$i]['id'],
                    $depth + 1
                );
            }
        }

        return $newsGroupTree;
    }

    public function respondWithCollectionPagination($data)
    {
        return $data;
    }

    protected function _getTextPagination(LengthAwarePaginator $paginator)
    {
        $data = [];

        if (
            $paginator instanceof LengthAwarePaginator && $paginator->count()
        ) {
            $data = $paginator->toArray();

            unset($data['data']);
        }

        return $data;
    }
}
