<?php

namespace DaydreamLab\Media\Resources\File\Admin\Models;

use DaydreamLab\JJAJ\Traits\FormatDateTime;
use DaydreamLab\JJAJ\Traits\FormatFileSize;
use Illuminate\Http\Resources\Json\JsonResource;

class FileAdminResource extends JsonResource
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
        $user = $request->user('api');

        return [
            'id'            => $this->id,
            'uuid'          => $this->uuid,
            'name'          => $this->name,
            'categoryId'    => $this->category_id,
            'categoryTitle' => $this->category ? $this->category->title : null,
            'state'         => $this->state,
            'contentType'   => $this->contentType,
            'extension'     => $this->extension,
            'size'          => $this->formatFileSize($this->size),
            'url'           => $this->url,
            'description'   => $this->description,
            'access'        => $this->access,
            'ordering'      => $this->ordering,
            'params'        => $this->params,
            'lockedAt'      => $this->getDateTimeString($this->locked_at, $user->timezone),
            'createdAt'     => $this->getDateTimeString($this->created_at, $user->timezone),
            'updatedAt'     => $this->getDateTimeString($this->updated_at, $user->timezone),
            'lockerName'    => $this->lockerName,
            'creatorName'   => $this->creatorName,
            'updaterName'   => $this->updaterName,
        ];
    }
}
