<?php

namespace DaydreamLab\Media\Requests\Media;

use DaydreamLab\JJAJ\Requests\AdminRequest;

class MediaMovePost extends AdminRequest
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
            'name'      => 'required|string',
            'target'    => 'required|string',
        ];
    }
}
