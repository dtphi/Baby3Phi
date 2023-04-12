<?php

namespace App\Contacts\Apis\Fronts\Repositories;

interface Home
{
    public function getMenuCategories($parentId = 0);
}
