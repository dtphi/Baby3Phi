<?php

namespace App\Http\Resources\InformationCategorys;

use Illuminate\Http\Resources\Json\ResourceCollection;

class InformationCategoryCollection extends ResourceCollection
{
    /**
     * @author : dtphi .
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'results' => $this->collection,
            'messages' => __('admins/group_information'),
            'errors'  => [],
            'status'  => 1000
        ];
    }
}
