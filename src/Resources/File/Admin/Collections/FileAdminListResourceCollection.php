<?php

namespace DaydreamLab\User\Resources\User\Admin\Collections;

use DaydreamLab\JJAJ\Resources\BaseResourceCollection;
use DaydreamLab\Media\Resources\File\Admin\Models\FileAdminResource;
use DaydreamLab\User\Resources\User\Admin\Models\UserAdminListResource;

class FileAdminListResourceCollection extends BaseResourceCollection
{
    public $collects = FileAdminResource::class;

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
