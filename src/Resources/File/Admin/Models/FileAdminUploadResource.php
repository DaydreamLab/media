<?php

namespace DaydreamLab\Media\Resources\File\Admin\Models;

use DaydreamLab\JJAJ\Traits\FormatDateTime;
use DaydreamLab\JJAJ\Traits\FormatFileSize;
use DaydreamLab\Media\Models\File\File;
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
        if ($this->resource instanceof File) {
            $data = [
                'id'            => $this['id'],
                'uuid'          => $this['uuid'],
                'name'          => $this['name'],
                'contentType'   => $this['contentType'],
                'size'          => $this['size'],
                'downloadLink'  => $this['downloadLink']
            ];
        } else {
            $data =  [
                'name'          => $this['name'],
                'blobName'      => $this['blobName'],
                'contentType'   => $this['contentType'],
                'extension'     => $this['extension'],
                'url'           => $this['url'],
                'size'          => $this['size'],
            ];
        }

        return $data;
    }
}
