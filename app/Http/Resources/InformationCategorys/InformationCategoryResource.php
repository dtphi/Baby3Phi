<?php

namespace App\Http\Resources\InformationCategorys;

use Illuminate\Http\Resources\Json\JsonResource;

class InformationCategoryResource extends JsonResource
{
    /**
     * @var string
     */
    public static $wrap = 'InformationCategory';

    /**
     * @author : dtphi .
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->resource) {
            return $this->__getJsonResource();
        }

        return [];
    }

    /**
     * @author : dtphi .
     * @return array
     */
    private function __getJsonResource()
    {
        return array(
            'category_id'      => $this->resource->category_id,
            'parent_id'        => $this->resource->parent_id,
            'sort_order'       => $this->resource->sort_order,
            'status'           => $this->resource->status,
            'created_at'       => $this->resource->created_at,
            'category_name'    => $this->resource->name,
            'name'             => $this->resource->name,
            'tag'              => $this->resource->tag,
            'description'      => htmlspecialchars_decode($this->resource->description),
            'meta_title'       => $this->resource->meta_title,
            'meta_description' => $this->resource->meta_description,
            'meta_keyword'     => $this->resource->meta_keyword,
            'layout_id'        => $this->resource->layout_id,
            'path'             => $this->resource->path
        );
    }
}
