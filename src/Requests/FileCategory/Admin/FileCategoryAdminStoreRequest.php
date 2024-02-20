<?php

namespace DaydreamLab\Media\Requests\FileCategory\Admin;

use DaydreamLab\Media\Requests\MediaStoreRequest;
use Illuminate\Validation\Rule;

class FileCategoryAdminStoreRequest extends MediaStoreRequest
{
    protected $modelName = 'FileCategory';

    protected $apiMethod = 'storeFileCategory';
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
            'id'            => 'nullable|integer',
            'title'         => 'required|string',
            'state'         => ['required', Rule::in([0, 1, -1, -2])],
            'description'   => 'nullable|string',
            'contentType'   => 'nullable|string',
            'extension'     => 'nullable|string',
            'params'        => 'nullable|array',
        ];

        return array_merge(parent::rules(), $rules);
    }


    public function validated($key = null, $default = null)
    {
        $validated = parent::validated($key, $default);

        if (!$validated->get('contentType')) {
          $validated->put('contentType', 'file');
        }

        return $validated;
    }
}
