<?php

namespace DaydreamLab\Media\Resources\Media\Admin\Models;

use DaydreamLab\JJAJ\Helpers\Helper;
use DaydreamLab\JJAJ\Traits\FormatDateTime;
use DaydreamLab\JJAJ\Resources\BaseJsonResource;

class MediaAdminListResource extends BaseJsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = $request->user('api');
        return [
            'children'      => $this->children,
            'modified'      => $this->modified,
            'name'          => $this->name,
            'path'          => $this->path,
            'size'          => $this->size,
            'thumb'         => $this->thumb,
            'type'          => $this->type,
            'url'           => $this->url,
            'extension'     => ($this->extension) ? : ''
        ];
    }

}
