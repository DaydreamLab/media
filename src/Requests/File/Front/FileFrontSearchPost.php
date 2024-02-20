<?php

namespace DaydreamLab\Media\Requests\File\Front;

use DaydreamLab\Media\Requests\MediaSearchRequest;
use Illuminate\Validation\Rule;

class FileFrontSearchPost extends MediaSearchRequest
{
    protected $searchKeys = ['name', 'description'];

    protected $modelName = 'File';

    protected $needAuth = false;

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

            'state'     => [
                'nullable',
                'integer',
                Rule::in([0,1,-2])
            ],
            'contentType'   => 'nullable|string',
            'categoryAlias' => 'nullable|string',
            'brand_alias'   => 'nullable|string',
            'search_date'   => 'nullable|string'
        ];

        return array_merge(parent::rules(), $rules);
    }


    public function validated($key = null, $default = null)
    {
        $validated = parent::validated($key, $default);

//        $q = $validated->get('q');
//        # 過濾可觀看的品牌
//        if (!$this->user()->isSuperUser && $this->user()->isAdmin) {
//            $q = $q->whereHas('brands', function ($q) {
//                $q->whereIn('brands_files_maps.brand_id', $this->user()->brands->pluck('id'));
//            });
//        }
//        $validated->put('q', $q);


        return $validated;
    }
}