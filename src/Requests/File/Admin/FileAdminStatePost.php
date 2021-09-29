<?php

namespace DaydreamLab\Media\Requests\File\Admin;

use DaydreamLab\Media\Requests\MediaStateRequest;
use Illuminate\Validation\Rule;

class FileAdminStatePost extends MediaStateRequest
{
    protected $modelName = 'File';

    protected $apiMethod = 'stateFile';
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
            'ids.*'     => 'required|integer',
            'state'     => [
                'required',
                'integer',
                Rule::in([0,1,-2])
            ]
        ];
    }
}
