<?php

namespace DaydreamLab\Media\Resources\File\Front\Models;

use DaydreamLab\JJAJ\Resources\BaseJsonResource;
use DaydreamLab\JJAJ\Traits\FormatFileSize;

class FileFrontSearchResource extends BaseJsonResource
{
    use FormatFileSize;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'uuid'          => $this->uuid,
            'category'      => $this->category->title,
            'name'          => $this->name,
            'size'          => $this->formatFileSize($this->size),
            'createdAt'     => $this->getDateTimeString($this->created_at),
            'downloadLink'  => $this->downloadLink
        ];
    }
}
