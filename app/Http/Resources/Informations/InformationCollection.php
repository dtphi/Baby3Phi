<?php

namespace App\Http\Resources\Informations;

use Illuminate\Http\Resources\Json\ResourceCollection;

class InformationCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'results' => $this->collection,
            'messages' => __('admins/information'),
            'errors'  => [],
            'status'  => 1000
        ];
    }
}
