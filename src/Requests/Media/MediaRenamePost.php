<?php

namespace DaydreamLab\Media\Requests\Media;

use DaydreamLab\JJAJ\Requests\AdminRequest;
use Illuminate\Validation\Rule;


class MediaRenamePost extends AdminRequest
{
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
            'dir'       => 'required|string',
            'name'      => 'required_if:type,file|string',
            'rename'    => 'required|string',
            'type'      => [
                'required',
                Rule::in(['file', 'folder'])
            ]
        ];
    }
}
