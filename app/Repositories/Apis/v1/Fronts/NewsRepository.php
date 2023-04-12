<?php

namespace App\Repositories\Apis\Fronts;

use App\Http\Common\Tables;
use App\Contacts\Apis\Fronts\Repositories\News as InfoRepo;
use App\Models\Information;
use App\Models\ModelRelations\InformationRelated;
use App\Models\ModelRelations\InformationToCategory;
use DB;

final class NewsRepository extends ServiceRepository implements InfoRepo
{
    /**
     * @author : dtphi .
     * NewsService constructor.
     */
    public function __construct()
    {
        $this->model       = new Information();
        $this->infoCate    = new InformationToCategory();
        $this->infoRelated = new InformationRelated();
    }

    public function apiGetInfo(int $information_id): array
    {
        // TODO: Implement apiGetDetail() method.
        $result = $this->model->findOrFail($information_id);
        if ($result) {
            return [
                'information_id'   => $result->information_id,
                'name'             => $result->name,
                'date_available'   => date_format(date_create($result->date_available), "d-m-Y"),
                'sort_description' => html_entity_decode($result->sort_description),
                'description'      => $result->description,
                'image'            => $result->image,
                'viewed'           => $result->viewed,
                'vote'             => $result->vote,
                'tag'              => (!empty($result->tag)) ? explode(',', $result->tag) : [],
                'albums'           => $result->arr_album_list,
                'related_category' => !empty($result->arr_category_list) ? $result->arr_category_list[0] : null
            ];
        } else {
            return [];
        }
    }

    public function apiGetLatestInfos(int $limit = B3P_FRONT_LIMIT): object
    {
        $query = $this->model->select('information_id')
            ->orderByDescDateAvailable()
            ->limit($limit);

        return $query->get();
    }

    public function apiGetCategories(int $infoId): object
    {
        $query = $this->infoCate->select()
            ->filterByInfoId($infoId);

        return $query->get();
    }

    public function apiGetInfoRelated(int $infoId): object
    {
        $query = $this->infoRelated->select()
            ->lfJoinInfo()
            ->filterByInfoId($infoId);


        return $query->get();
    }

    public function apiGetPopularInfos(int $limit = B3P_FRONT_LIMIT): object
    {
        $query = $this->modelInfo->select('information_id')
            ->orderByDescViewed()
            ->limit($limit);

        return $query->get();
    }

    public function apiUpdateViewed(int $infoId): object
    {
        $info = $this->model->find($infoId);
        if ($info) {
            $info->increment('viewed');
        }

        return $info;
    }

    public function apiGetInfoList(array $data = array()): object
    {
        $infoType = 1;
        if (isset($data['infoType'])) {
            $infoType = (int)$data['infoType'];
        }
        if (!empty($data['news_group_type'])) {
            return $this->_apiGetTagInfoList($data);
        }

        $query = DB::table(Tables::tbl_information_to_categorys)->select([
            'category_id',
            'date_available',
            'sort_description',
            'image',
            Tables::tbl_informations . '.information_id',
            'information_type',
            'name',
            'name_slug',
            'viewed',
            'vote'
        ])
            ->leftJoin(
                Tables::tbl_informations,
                Tables::tbl_information_to_categorys . '.information_id',
                '=',
                Tables::tbl_informations . '.information_id'
            )
            ->leftJoin(
                Tables::tbl_information_descriptions,
                Tables::tbl_informations . '.information_id',
                '=',
                Tables::tbl_information_descriptions . '.information_id'
            )
            ->where('status', '=', '1');

        if (isset($data['all_category_children']) && !empty($data['all_category_children'])) {
            $query->whereIn('category_id', $data['all_category_children']);
        } else {
            if (isset($data['category_id']) && $data['category_id']) {
                $query->where('category_id', '=', $data['category_id']);
            } else {
                $query->where('information_type', '=', $infoType);
            }
        }

        $limit = B3P_FRONT_LIMIT;
        if (isset($data['limit'])) {
            $limit = (int)$data['limit'];
        }

        $query->orderByDesc('sort_order');
        $query->orderByDesc('date_available');

        return $query->paginate($limit);
    }

    public function _apiGetTagInfoList($data = array())
    {
        $query = DB::table(Tables::tbl_information_to_categorys)->select([
            'category_id',
            'date_available',
            'sort_description',
            'image',
            Tables::tbl_informations . '.information_id',
            'information_type',
            'name',
            'name_slug',
            'viewed',
            'vote'
        ])
            ->leftJoin(
                Tables::tbl_informations,
                Tables::tbl_information_to_categorys . '.information_id',
                '=',
                Tables::tbl_informations . '.information_id'
            )
            ->leftJoin(
                Tables::tbl_information_descriptions,
                Tables::tbl_informations . '.information_id',
                '=',
                Tables::tbl_information_descriptions . '.information_id'
            )
            ->where('status', '=', '1');

        $limit = B3P_FRONT_LIMIT;
        if (isset($data['limit'])) {
            $limit = (int)$data['limit'];
        }

        $query->orderByDesc('sort_order');
        $query->orderByDesc('date_available');

        return $query->paginate($limit);
    }

    public function apiGetInfoListByIds(array $data = array()): object
    {
        $infoType = 1;
        if (isset($data['infoType'])) {
            $infoType = (int)$data['infoType'];
        }

        $query = DB::table(Tables::tbl_informations)->select(
            [
                'date_available',
                'sort_description',
                'image',
                Tables::tbl_informations . '.information_id',
                'information_type',
                'name',
                'name_slug',
                'viewed',
                'vote'
            ]
        )
            ->leftJoin(
                Tables::tbl_information_descriptions,
                Tables::tbl_informations . '.information_id',
                '=',
                Tables::tbl_information_descriptions . '.information_id'
            )
            ->where('status', '=', '1')
            ->where('information_type', '=', $infoType);

        if (isset($data['information_ids'])) {
            $query->whereIn(Tables::tbl_informations . '.information_id', $data['information_ids']);
        }

        $limit = B3P_FRONT_LIMIT;
        if (isset($data['limit'])) {
            $limit = (int)$data['limit'];
        }

        $query->orderByDesc('sort_order');
        $query->orderByDesc('date_available');

        return $query->get();
    }

    public function apiGetInfoCarouselListByIds(array $data = array()): object
    {

        $query = DB::table(Tables::tbl_information_carousels)->select(
            [
                'date_available',
                'sort_description',
                'image',
                'image_origin',
                'information_id',
                'information_type',
                'name',
                'name_slug',
                'viewed',
                'vote'
            ]
        );

        if (isset($data['information_ids'])) {
            $query->whereIn(Tables::tbl_information_carousels . '.information_id', $data['information_ids']);
        }

        $query->orderByDesc('sort_order');
        $query->orderByDesc('date_available');

        return $query->get();
    }
}
