<?php

namespace DaydreamLab\Media\Requests\Media;

use DaydreamLab\JJAJ\Requests\AdminRequest;
use Illuminate\Validation\Rule;


class MediaGetFolderItemsPost extends AdminRequest
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
            'order_by'  => [
                'nullable',
                Rule::in(['name', 'modified'])
            ],
            'order'     => [
                'nullable',
                Rule::in(['asc', 'desc'])
            ]
        ];
    }
}
