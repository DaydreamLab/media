<?php

namespace DaydreamLab\Media\Resources\File\Front\Models;

use DaydreamLab\JJAJ\Resources\BaseJsonResource;

class FileFrontSearchResource extends BaseJsonResource
{
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
            'name'          => $this->name,
            'size'          => $this->formatSize($this->size),
        ];
    }


    public function formatSize($size)
    {
        if ($size < 1024) {
            return $size.'KB';
        } elseif ($size > 1024 && $size < pow(1024, 2)) {
            return $size / 1024 . '.' . ceil($size % 1024) . 'MB';
        } else {
            return $size / pow(1024, 2) . '.' . ceil($size % pow(1023,2)) . 'GB';
        }
    }
}
