<?php

namespace DaydreamLab\Media\Requests\File\Admin;

use DaydreamLab\Media\Requests\MediaGetItemRequest;

class FileAdminGetItem extends MediaGetItemRequest
{
    protected $modelName = 'File';

    protected $apiMethod = 'getFile';
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
        ];
    }
}
