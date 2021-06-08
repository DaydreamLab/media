<?php

namespace DaydreamLab\Media\Requests\Media\Admin;

use DaydreamLab\Media\Requests\Media\MediaRenamePost;
use Illuminate\Validation\Rule;

class MediaAdminRenamePost extends MediaRenamePost
{
    protected $modelName = 'Media';

    protected $apiMethod = 'renameMedia';
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
