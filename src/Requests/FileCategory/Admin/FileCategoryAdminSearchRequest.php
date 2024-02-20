<?php

namespace DaydreamLab\Media\Requests\FileCategory\Admin;

use DaydreamLab\Media\Requests\MediaSearchRequest;
use Illuminate\Validation\Rule;

class FileCategoryAdminSearchRequest extends MediaSearchRequest
{
    protected $modelName = 'FileCategory';

    protected $apiMethod = 'searchFileCategory';
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
            'state'         => [
                'nullable',
                'integer',
                Rule::in([0,1,-1,-2])
            ],
            'contentType'   => 'nullable|string'
        ];

        return array_merge(parent::rules(), $rules);
    }


    public function validated($key = null, $default = null)
    {
        $validated = parent::validated($key, $default);

        if ( $validated->get('state') == '' ) {
            $validated->forget('state');
            $validated['q'] = $this->q->whereIn('state', [0, 1]);
        }

        $validated['q'] = $this->q->whereNull('extension');

        return $validated;
    }
}
