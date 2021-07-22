<?php

namespace DaydreamLab\Media\Requests\FileCategory\Admin;

use DaydreamLab\Media\Requests\MediaSearchRequest;

class FileCategoryAdminSearchRequest extends MediaSearchRequest
{
    protected $modelName = 'FileCategory';

    protected $apiMethod = 'searchFileCategory';
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
        $rules =[
            'contentType'   => 'nullable|string'
        ];

        return array_merge(parent::rules(), $rules);
    }


    public function validated()
    {
        $validated = parent::validated();

        return $validated;
    }
}
