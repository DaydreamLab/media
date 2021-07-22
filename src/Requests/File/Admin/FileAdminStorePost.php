<?php

namespace DaydreamLab\Media\Requests\File\Admin;

use DaydreamLab\JJAJ\Requests\AdminRequest;
use DaydreamLab\Media\Helpers\MediaHelper;
use Illuminate\Validation\Rule;

class FileAdminStorePost extends AdminRequest
{
    protected $modelName = 'File';

    protected $apiMethod = 'storeFile';
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
            'categoryId'    => 'required|integer',
            'state'         => [
                'nullable',
                'integer',
                Rule::in([0,1,-1,-2])
            ],
            'introtext'     => 'nullable|string',
            'description'   => 'nullable|string',
            'file'          => 'nullable|max:'.$media_config['upload_limit'],
            'encrypted'     => ['required', Rule::in([0, 1])],
            'password'      => 'required_with:encrypted|max:16|min:8',
            'notifyEmails'  => 'nullable|array',
            'notifyEmails.*'=> 'nullable|email',
            'groupIds'      => 'nullable|array',
            'groupIds.*'    => 'nullable|integer',
            'access'        => 'nullable|integer',
            'ordering'      => 'nullable|integer',
            'params'        => 'nullable|string',
            'tags'          => 'nullable|array',
            'tags.*'        => 'nullable|array',
            'tags.*.id'     => 'required|integer',
            'tags.*.title'  => 'nullable|string',

            'brands'        => 'nullable|array',
            'brands.*'      => 'nullable|array',
            'brands.*.id'   => 'required|integer',
        ];
    }


    public function validated()
    {
        $validated = parent::validated();

        $validated->put('category_id', $validated->get('categoryId'));
        $validated->put('contentType', $this->file->getMimeType());
        $validated->put('extension', $this->file->extension());
        $validated->put('size', ceil((double) ($this->file->getSize() / 1024)));
        $validated->forget('categoryId');

        return $validated;
    }
}
