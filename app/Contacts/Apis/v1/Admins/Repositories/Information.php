<?php

namespace App\Contacts\Apis\Admins\Repositories;

interface Information
{
    public function apiInsert($data = []);

    public function getInfoDesById($infoId = null);

    public function apiUpdate($model, $data = []);

    public function apiGetBuilderInformations($data = [], $limit = 5);

    public function apiGetInformations($data = array(), $limit = 5);

    public function deleteInformation($model = null);
}
