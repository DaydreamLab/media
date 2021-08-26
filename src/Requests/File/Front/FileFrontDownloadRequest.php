<?php

namespace DaydreamLab\Media\Requests\File\Front;

use DaydreamLab\JJAJ\Requests\AdminRequest;

class FileFrontDownloadRequest extends AdminRequest
{
    protected $package = 'Media';

    protected $modelName = 'File';

    protected $apiMethod = 'getFile';

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
            'password'  => 'nullable|string'
        ];
    }
}
