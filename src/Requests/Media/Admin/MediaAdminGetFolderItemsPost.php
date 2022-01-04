<?php

namespace DaydreamLab\Media\Requests\Media\Admin;

use DaydreamLab\JJAJ\Requests\AdminRequest;
use Illuminate\Validation\Rule;

class MediaAdminGetFolderItemsPost extends AdminRequest
{
    protected $modelName = 'Media';

    protected $apiMethod = 'getMediaAllItems';

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
            'order_by'  => [
                'nullable',
                Rule::in(['name', 'modified'])
            ],
            'order'     => [
                'nullable',
                Rule::in(['asc', 'desc'])
            ]
        ];
        return array_merge(parent::rules(), $rules);
    }
}
