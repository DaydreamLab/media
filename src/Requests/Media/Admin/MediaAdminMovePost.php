<?php

namespace DaydreamLab\Media\Requests\Media\Admin;

use DaydreamLab\JJAJ\Requests\AdminRequest;

class MediaAdminMovePost extends AdminRequest
{
    protected $modelName = 'Media';

    protected $apiMethod = 'moveMedia';

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
        $rules = [
            'dir'       => 'required|string',
            'name'      => 'required|string',
            'target'    => 'required|string',
        ];
        return array_merge($rules, parent::rules());
    }
}
