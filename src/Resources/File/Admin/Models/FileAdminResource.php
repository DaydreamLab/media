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
            'userGroupId'   => $this->userGroupId,
            'userGroupTitle'=> $this->userGroup ? $this->userGroup->title : '',
            'state'         => $this->state,
            'originFileName'=> ($this->blobName) ? substr($this->blobName, 6) : '',
            'blobName'      => $this->blobName,
            'contentType'   => $this->contentType,
            'extension'     => $this->extension,
            'size'          => $this->formatFileSize($this->size),
            'url'           => $this->url,
            'web_url'       => $this->web_url,
            'introtext'     => $this->introtext,
            'description'   => $this->description,
            'access'        => $this->access,
            'ordering'      => $this->ordering,
            'params'        => $this->params,
            'tags'          => $this->tags,
            'brands'        => $this->brands->map(function ($b) {
                return $b->only(['id', 'title']);
            }),
            'downloadCount' => $this->downloadRecords->count(),
            'locked_at'     => $this->getDateTimeString($this->locked_at, $user->timezone),
            'created_at'    => $this->getDateTimeString($this->created_at, $user->timezone),
            'updated_at'    => $this->getDateTimeString($this->updated_at, $user->timezone),
            'publish_up'    => $this->getDateTimeString($this->publish_up, $user->timezone),
            'publish_down'  => $this->getDateTimeString($this->publish_down, $user->timezone),
            'lockerName'    => $this->lockerName,
            'creatorName'   => $this->creatorName,
            'updaterName'   => $this->updaterName,
            'locker'        => ($this->locker) ? $this->locker->only(['id', 'uuid', 'name']) : []
        ];
    }
}
