<?php

namespace DaydreamLab\Media\Requests\FileCategory\Admin;

use DaydreamLab\Media\Requests\MediaGetItemRequest;

class FileCategoryAdminGetItemRequest extends MediaGetItemRequest
{
    protected $modelName = 'FileCategory';

    protected $apiMethod = 'getFileCategory';
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
            //
        ];

        return array_merge(parent::rules(), $rules);
    }


    public function validated()
    {
        $validated = parent::validated();

        return $validated;
    }
}
