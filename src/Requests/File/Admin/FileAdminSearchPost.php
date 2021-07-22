<?php

namespace DaydreamLab\Media\Requests\File\Admin;

use DaydreamLab\JJAJ\Requests\ListRequest;
use Illuminate\Validation\Rule;

class FileAdminSearchPost extends ListRequest
{
    protected $modelName = 'File';

    protected $apiMethod = 'searchFile';

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
            'title'     => 'nullable|string',
            'state'     => [
                'nullable',
                'integer',
                Rule::in([0,1,-2])
            ],
            'brand_id'  => 'nullable|integer',
        ];

        return array_merge(parent::rules(), $rules);
    }


    public function validated()
    {
        $validated = parent::validated();
        if ( $brand_id = $validated->get('brand_id') ) {
            $validated['q'] = $this->q->whereHas('brands', function ($query) use ($brand_id) {
                $query->where('brands_files_maps.brand_id', '=', $brand_id);
            });
        }
        $validated->forget('brand_id');

        return $validated;
    }
}
