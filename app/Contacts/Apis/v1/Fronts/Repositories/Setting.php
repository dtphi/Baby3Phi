<?php

namespace App\Contacts\Apis\Fronts\Repositories;

interface Setting
{
    public function apiGetList(array $options = [], $limit = 15);

    public function apiGetCategoryByIds($ids = []);

    public function apiGetDetail($id = null);

    public function apiGetSettingByCodes($code = '');
}
