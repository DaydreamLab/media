<?php
namespace DaydreamLab\Media\Models\File\Front;

use DaydreamLab\Media\Models\File\File;
use DaydreamLab\Media\Models\FileCategory\Front\FileCategoryFront;

class FileFront extends File
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'files';

    protected $hidden = [
        'id',
        'category_id',
        'pivot',
        'state',
        'access',
        'password',
        'created_by',
        'updated_by',
        'locked_at',
        'locked_by'
    ];


    public function category()
    {
        return $this->belongsTo(FileCategoryFront::class, 'category_id', 'id');
    }
}