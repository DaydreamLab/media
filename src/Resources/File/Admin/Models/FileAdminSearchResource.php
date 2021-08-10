<?php

namespace DaydreamLab\Media\Resources\File\Admin\Models;

use DaydreamLab\JJAJ\Resources\BaseJsonResource;

class FileAdminSearchResource extends BaseJsonResource
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
            'id'            => $this->id,
            'name'          => $this->name,
            'categoryTitle' => $this->category ? $this->category->title : null,
            'state'         => $this->state,
            'size'          => $this->size,
            'access'        => $this->access,
            'ordering'      => $this->ordering,
            'lockedAt'      => $this->getDateTimeString($this->locked_at, $user->timezone),
            'createdAt'     => $this->getDateTimeString($this->created_at, $user->timezone),
            'updatedAt'     => $this->getDateTimeString($this->updated_at, $user->timezone),
            'lockerName'    => $this->lockerName,
            'creatorName'   => $this->creatorName,
            'updaterName'   => $this->updaterName,
        ];
    }
}
