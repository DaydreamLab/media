<?php

namespace DaydreamLab\Media\Requests\Media\Admin;

use DaydreamLab\JJAJ\Requests\AdminRequest;
use Illuminate\Validation\Rule;

class MediaAdminRenamePost extends AdminRequest
{
    protected $modelName = 'Media';

    protected $apiMethod = 'renameMedia';

    protected $needAuth = false;
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
            'rename'    => 'required|string',
            'type'      => [
                'required',
                Rule::in(['file', 'folder'])
            ]
        ];
        return array_merge(parent::rules(), $rules);
    }
}
