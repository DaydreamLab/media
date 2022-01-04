<?php

namespace DaydreamLab\Media\Requests\Media\Admin;

use DaydreamLab\JJAJ\Requests\AdminRequest;

class MediaAdminGetFoldersPost extends AdminRequest
{
    protected $modelName = 'Media';

    protected $apiMethod = 'getMediaAllFolders';

    protected $needAuth = false;
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
        return array_merge(parent::rules(), $rules);
    }
}
