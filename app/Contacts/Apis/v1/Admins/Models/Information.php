<?php

namespace App\Contacts\Apis\Admins\Models;

interface Information
{
    public function sqlStatementIncrementViewed(int $infoId): string;

    public static function fcDeleteByInfoId($infoId = null);

    public function setArrCategoryDisplayList($value = []);

    public static function insertForce(
        $infoId = null,
        $image = null,
        $dateAvailable = null,
        $sortOrder = 0,
        $status = 1,
        $viewed = 0,
        $vote = 0,
        $sortDes = '',
        $nameSlug = '',
        $createUser = 0,
        $infoType = 1
    );

    public static function truncateForce();
}
