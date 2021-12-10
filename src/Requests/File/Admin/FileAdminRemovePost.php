<?php

namespace DaydreamLab\Media\Requests\File\Admin;

use DaydreamLab\Media\Requests\MediaRemoveRequest;

class FileAdminRemovePost extends MediaRemoveRequest
{
    protected $modelName = 'File';

    protected $apiMethod = 'deleteFile';

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
        return [
            'ids'       => 'required|array',
            'ids.*'     => 'required|integer'
        ];
    }
}
