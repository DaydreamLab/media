<?php

namespace DaydreamLab\Media\Requests;

use DaydreamLab\Cms\Helpers\RequestHelper;
use DaydreamLab\JJAJ\Requests\BaseRestoreRequest;

abstract class MediaRestoreRequest extends BaseRestoreRequest
{
    protected $package = 'Media';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (RequestHelper::isBrandAdminPage(
            $this->get('pageGroupId'),
            $this->get('pageId'),
            $this->modelName)) {
            return RequestHelper::brandAdminPageAuthorize(
                $this->user()->apis,
                $this->apiMethod,
                $this->modelName);
        }
        return parent::authorize();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules =[
            //
        ];

        return array_merge(parent::rules(), $rules);
    }


    public function validated()
    {
        $validated = parent::validated();

        return $validated;
    }
}
