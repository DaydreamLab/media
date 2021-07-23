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

        $q = $validated->get('q');
        if ($brand_id = $validated->get('brand_id') ) {
            $q = $q->whereHas('brands', function ($query) use ($brand_id) {
                $query->where('brands_files_maps.brand_id', '=', $brand_id);
            });
        }
        $validated->forget('brand_id');

        # 過濾可觀看的品牌
        if (!$this->user()->isSuperUser && $this->user()->isAdmin) {
            $q = $q->whereHas('brands', function ($q) {
                $q->whereIn('brands_files_maps.brand_id', $this->user()->brands->pluck('id'));
            });
        }

        $validated->put('q', $q);

        return $validated;
    }
}
