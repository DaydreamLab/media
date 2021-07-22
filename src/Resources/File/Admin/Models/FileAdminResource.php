<?php

namespace DaydreamLab\Media\Resources\File\Admin\Models;

use DaydreamLab\JJAJ\Helpers\Helper;
use DaydreamLab\JJAJ\Traits\FormatDateTime;
use Illuminate\Http\Resources\Json\JsonResource;

class FileAdminResource extends JsonResource
{
    use FormatDateTime;
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
            'size'          => $this->formatSize($this->size),
            'url'           => $this->url,
            'description'   => $this->description,
            'access'        => $this->access,
            'ordering'      => $this->ordering,
            'params'        => $this->params,
            'tags'          => $this->tags,
            'brands'        => $this->brands->map(function ($b) {
                return $b->only(['id', 'title']);
            }),
            'lockedAt'      => $this->getDateTimeString($this->locked_at, $user->timezone),
            'createdAt'     => $this->getDateTimeString($this->created_at, $user->timezone),
            'updatedAt'     => $this->getDateTimeString($this->updated_at, $user->timezone),
            'lockerName'    => $this->lockerName,
            'creatorName'   => $this->creatorName,
            'updaterName'   => $this->updaterName,
            'locker'        => ($this->locker) ? $this->locker->only(['id', 'uuid', 'name']) : []
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
