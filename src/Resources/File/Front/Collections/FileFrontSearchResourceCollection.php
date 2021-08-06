<?php

namespace DaydreamLab\Media\Resources\File\Front\Collections;

use DaydreamLab\JJAJ\Resources\BaseResourceCollection;
use DaydreamLab\Media\Resources\File\Front\Models\FileFrontSearchResource;

class FileFrontSearchResourceCollection extends BaseResourceCollection
{
    public $collects = FileFrontSearchResource::class;

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
