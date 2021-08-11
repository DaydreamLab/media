<?php

namespace DaydreamLab\Media\Requests\File\Admin;

use DaydreamLab\JJAJ\Requests\AdminRequest;
use DaydreamLab\Media\Helpers\MediaHelper;
use Illuminate\Validation\Rule;

class FileAdminUploadRequest extends AdminRequest
{
    protected $modelName = 'File';

    protected $apiMethod = 'uploadFile';
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
        $rules = [
            'createFile'    => ['required', Rule::in([0,1])],
            'contentType'   => 'nullable|string',
            'extension'     => 'nullable|string',
            'files'         => 'nullable|array',
            'files.*'       => 'required|max:'.$media_config['upload_limit'],
        ];

        return array_merge(parent::rules(), $rules);
    }


    public function validated()
    {
        $validated = parent::validated();

        $q = $validated->get('q');

        $contentType = $validated->get('contentType') ?: 'file';
        $q->where('contentType', $contentType);

        $extension = $validated->get('extension');
        if ($extension) {
            $q->where('extension', $extension);
        }

        return $validated;
    }
}
