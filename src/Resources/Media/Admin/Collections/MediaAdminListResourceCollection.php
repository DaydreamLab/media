<?php

namespace DaydreamLab\Media\Resources\Media\Admin\Collections;

use DaydreamLab\JJAJ\Helpers\Helper;
use DaydreamLab\JJAJ\Traits\FormatDateTime;
use DaydreamLab\JJAJ\Resources\BaseResourceCollection;
use DaydreamLab\Media\Resources\Media\Admin\Models\MediaAdminListResource;

class MediaAdminListResourceCollection extends BaseResourceCollection
{
    public $collects = MediaAdminListResource::class;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

}
