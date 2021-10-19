<?php

namespace DaydreamLab\Media\Resources\File\Front\Models;

use DaydreamLab\JJAJ\Resources\BaseJsonResource;
use DaydreamLab\JJAJ\Traits\FormatFileSize;
use DaydreamLab\User\Models\User\UserGroup;

class FileFrontSearchResource extends BaseJsonResource
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
        $canDownload = 1;
        if ($this->userGroupId != 1) { # 不是公開檔案
            $user = $request->user('api');
            if (!$user) {
                $canDownload = 0;
            } else {
                $userGroup = UserGroup::where('id', $this->userGroupId)->first();
                $allowIds = $user->groups->first()->descendants->pluck('id')->toArray();
                $allowIds[] = $user->groups->first()->id;
                if (count( array_intersect($allowIds, [$userGroup->id]) ) == 0) {
                    $canDownload = 0;
                }
            }
        }
        return [
            'uuid'          => $this->uuid,
            'categoryTitle' => $this->categoryTitle,
            'title'         => $this->name,
            'contentType'   => $this->contentType,
            'description'   => $this->description,
            'size'          => $this->formatFileSize($this->size),
            'publishUp'     => $this->getDateTimeString($this->publish_up),
            'downloadLink'  => $this->downloadLink,
            'canDownload'   => $canDownload
        ];
    }
}
