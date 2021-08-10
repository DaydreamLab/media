<?php

namespace DaydreamLab\Media\Resources\File\Admin\Collections;

use DaydreamLab\JJAJ\Resources\BaseResourceCollection;
use DaydreamLab\Media\Resources\File\Admin\Models\FileAdminUploadResource;

class FileAdminUploadResourceCollection extends BaseResourceCollection
{
    public $collects = FileAdminUploadResource::class;

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
