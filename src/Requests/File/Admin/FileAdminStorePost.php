<?php

namespace DaydreamLab\Media\Requests\File\Admin;

use DaydreamLab\JJAJ\Requests\AdminRequest;
use DaydreamLab\Media\Helpers\MediaHelper;
use Illuminate\Validation\Rule;

class FileAdminStorePost extends AdminRequest
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
        $media_config = MediaHelper::getMediaConfig();

        return [
            'id'            => 'nullable|integer',
            'name'          => 'required|string',
            'category_id'   => 'nullable|integer',
            'state'         => [
                'nullable',
                'integer',
                Rule::in([0,1,-2])
            ],
            'description'   => 'nullable|string',
            'access'        => 'nullable|integer',
            'ordering'       => 'nullable|integer',
            'file'          => 'nullable|max:'.$media_config['upload_limit'],
        ];
    }


    public function validated()
    {
        $validated = parent::validated();

        $media = $validated->file->get('media');


        exit();
    }
}
