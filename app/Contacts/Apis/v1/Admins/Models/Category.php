<?php

namespace App\Contacts\Apis\Admins\Models;

interface Category
{
    public static function getInformationCategorys(array $data): array;

    public static function fcDeleteByCateId(int $cateId): void;

    public static function insertForce(int $cateId = null, string $nameSlug = '', int $parentId = null, int $createUser = 0, int $status = 1): void;

    public static function truncateForce(): void;
}
