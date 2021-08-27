<?php

namespace DaydreamLab\Media\Requests\File\Admin;

use Carbon\Carbon;
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
            'uuid'          => 'nullable|string',
            'name'          => 'required|string',
            'categoryId'    => 'required|integer',
            'state'         => [
                'nullable',
                'integer',
                Rule::in([0,1,-1,-2])
            ],
            'introtext'     => 'nullable|string',
            'description'   => 'nullable|string',
            'blobName'      => 'nullable|string',
            'contentType'   => 'nullable|string',
            'extension'     => 'nullable|string',
            'size'          => 'nullable|string',
            'url'           => 'nullable|string',
            'web_url'       => 'nullable|string',
            'encrypted'     => ['required', Rule::in([0, 1])],
            'password'      => 'required_if:encrypted,1|nullable|max:16|min:8',
            'notifyEmails'  => 'nullable|array',
            'notifyEmails.*'=> 'nullable|email',
            'groupIds'      => 'nullable|array',
            'groupIds.*'    => 'nullable|integer',
            'access'        => 'nullable|integer',
            'ordering'      => 'nullable|integer',
            'params'        => 'nullable|array',
            'publish_up'    => 'nullable|date_format:Y-m-d H:i:s',
            'publish_down'  => 'nullable|date_format:Y-m-d H:i:s',

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
        //$validated->put('contentType', $this->file->getMimeType());
        //$validated->put('extension', $this->file->extension());
        //$validated->put('size', ceil((double) ($this->file->getSize() / 1024)));
        $validated->forget('categoryId');

        if ( $publish_up = $validated->get('publish_up') ) {
            $utc_publish_up = Carbon::parse($publish_up, $this->user('api')->timezone);
            $validated->put('publish_up', $utc_publish_up->tz(config('app.timezone'))->format('Y-m-d H:i:s'));
        }

        if ( $publish_down = $validated->get('publish_down') ) {
            $utc_publish_down = Carbon::parse($publish_down, $this->user('api')->timezone);
            $validated->put('publish_down', $utc_publish_down->tz(config('app.timezone'))->format('Y-m-d H:i:s'));
        }

        return $validated;
    }
}
