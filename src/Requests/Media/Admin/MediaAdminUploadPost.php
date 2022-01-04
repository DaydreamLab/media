<?php

namespace DaydreamLab\Media\Requests\Media\Admin;

use DaydreamLab\JJAJ\Requests\AdminRequest;
use DaydreamLab\Media\Helpers\MediaHelper;

class MediaAdminUploadPost extends AdminRequest
{
    protected $modelName = 'Media';

    protected $apiMethod = 'uploadMedia';

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
        $media_config = MediaHelper::getMediaConfig();
        $rules = [
            'files'     => 'required|array',
            'files.*'   => 'nullable|max:'.$media_config['upload_limit'],
            'dir'       => 'required|string',
        ];
        return array_merge(parent::rules(), $rules);
    }
}
