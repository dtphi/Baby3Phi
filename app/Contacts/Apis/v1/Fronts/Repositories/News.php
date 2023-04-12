<?php

namespace App\Contacts\Apis\Fronts\Repositories;

interface News
{
    public function apiGetInfo(int $information_id): array;

    public function apiGetLatestInfos(int $limit = B3P_FRONT_LIMIT): object;

    public function apiGetPopularInfos(int $limit = B3P_FRONT_LIMIT): object;

    public function apiGetCategories(int $infoId): object;

    public function apiGetInfoRelated(int $infoId): object;

    public function apiUpdateViewed(int $infoId): object;

    public function apiGetInfoList(array $data = array()): object;

    public function apiGetInfoListByIds(array $data = array()): object;

    public function apiGetInfoCarouselListByIds(array $data = array()): object;
}
