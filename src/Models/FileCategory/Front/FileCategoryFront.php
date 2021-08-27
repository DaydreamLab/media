<?php

namespace DaydreamLab\Media\Models\FileCategory\Front;

use DaydreamLab\Media\Models\FileCategory\FileCategory;

class FileCategoryFront extends FileCategory
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'file_categories';

    protected $hidden = [
        'id',
        'state',
        'contentType',
        'extension',
        'access',
        'ordering',
        'params',
        'locked_by',
        'created_by',
        'updated_by',
        'locked_at',
    ];
}
