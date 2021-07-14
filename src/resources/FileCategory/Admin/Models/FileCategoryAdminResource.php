<?php

namespace DaydreamLab\Media\Resources\FileCategory\Admin\Models;

use DaydreamLab\JJAJ\Helpers\Helper;
use DaydreamLab\JJAJ\Traits\FormatDateTime;
use Illuminate\Http\Resources\Json\JsonResource;

class FileCategoryAdminResource extends JsonResource
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
            'title'         => $this->title,
            'state'         => $this->state,
            'description'   => $this->description,
            'lockedAt'      => $this->getDateTimeString($this->locked_at, $user->timezone),
            'createdAt'     => $this->getDateTimeString($this->created_at, $user->timezone),
            'updatedAt'     => $this->getDateTimeString($this->updated_at, $user->timezone),
            'lockerName'    => $this->lockerName,
            'creatorName'   => $this->creatorName,
            'updaterName'   => $this->updaterName,
        ];
    }
}
