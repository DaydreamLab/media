<?php

namespace DaydreamLab\Media\Requests\Media\Admin;

use DaydreamLab\Media\Requests\Media\MediaGetFolderItemsPost;

class MediaAdminGetFolderItemsPost extends MediaGetFolderItemsPost
{
    protected $modelName = 'Media';

    protected $apiMethod = 'getMediaAllItems';
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return parent::authorize();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            //
        ];
        return array_merge($rules, parent::rules());
    }
}
