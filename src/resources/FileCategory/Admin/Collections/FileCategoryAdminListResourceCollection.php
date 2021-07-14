<?php

namespace DaydreamLab\Media\Resources\FileCategory\Admin\Collections;

use DaydreamLab\JJAJ\Resources\BaseResourceCollection;
use DaydreamLab\Media\Resources\FileCategory\Admin\Models\FileCategoryAdminResource;

class FileCategoryAdminListResourceCollection extends BaseResourceCollection
{
    public $collects = FileCategoryAdminResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
