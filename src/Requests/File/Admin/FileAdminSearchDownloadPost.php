<?php

namespace DaydreamLab\Media\Requests\File\Admin;

use DaydreamLab\Media\Requests\MediaSearchRequest;
use Illuminate\Validation\Rule;

class FileAdminSearchDownloadPost extends MediaSearchRequest
{
    protected $modelName = 'File';

    protected $apiMethod = 'searchFile';
    
    protected $needAuth = false;

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
            'fileId' => 'required|integer'

        ];

        return array_merge(parent::rules(), $rules);
    }


    public function validated()
    {
        $validated = parent::validated();

        return $validated;
    }
}
