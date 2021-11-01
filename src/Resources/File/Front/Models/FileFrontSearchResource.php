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
            'categoryTitle' => $this->categoryTitle,
            'name'          => $this->name,
            'description'   => $this->description,
            'size'          => $this->formatFileSize($this->size),
            'publishUp'     => $this->getDateTimeString($this->publish_up),
            'downloadLink'  => $this->downloadLink,
            'contentType'   => $this->contentType,
        ];
    }
}
