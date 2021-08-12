<?php

namespace DaydreamLab\Media\Resources\File\Admin\Models;

use DaydreamLab\JJAJ\Resources\BaseJsonResource;
use DaydreamLab\JJAJ\Traits\FormatFileSize;

class FileAdminSearchResource extends BaseJsonResource
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
        $user = $request->user('api');

        return [
            'id'            => $this->id,
            'uuid'          => $this->uuid,
            'name'          => $this->name,
            'introtext'     => $this->introtext,
            'categoryTitle' => $this->category ? $this->category->title : null,
            'brandTitle'    => ($this->brands) ? $this->brands->map(function ($b) {
                return $b->title;
            })->toArray() : [],
            'state'         => $this->state,
            'size'          => $this->formatFileSize($this->size),
            'access'        => $this->access,
            'ordering'      => $this->ordering,
            'lockedAt'      => $this->getDateTimeString($this->locked_at, $user->timezone),
            'createdAt'     => $this->getDateTimeString($this->created_at, $user->timezone),
            'updatedAt'     => $this->getDateTimeString($this->updated_at, $user->timezone),
            'lockerName'    => $this->lockerName,
            'creatorName'   => $this->creatorName,
            'updaterName'   => $this->updaterName,
            'locker'        => ($this->locker) ? $this->locker->only(['id', 'uuid', 'name']) : []
        ];
    }
}
