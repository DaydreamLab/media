<?php

namespace DaydreamLab\Media\Resources\File\Admin\Models;

use DaydreamLab\JJAJ\Traits\FormatDateTime;
use DaydreamLab\JJAJ\Traits\FormatFileSize;
use Illuminate\Http\Resources\Json\JsonResource;

class FileAdminUploadResource extends JsonResource
{
    use FormatDateTime, FormatFileSize;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name'          => $this['name'],
            'blobName'      => $this['blobName'],
        ];
    }
}
