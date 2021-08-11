<?php

namespace DaydreamLab\Media\Models\FileCategory;

use DaydreamLab\JJAJ\Traits\UserInfo;
use DaydreamLab\Media\Models\MediaModel;
use DaydreamLab\JJAJ\Traits\RecordChanger;

class FileCategory extends MediaModel
{
    use UserInfo, RecordChanger {
        RecordChanger::boot as traitBoot;
    }
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'file_categories';


    protected $name = 'FileCategory';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'state',
        'description',
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


    /**
     * The attributes that should be hidden for arrays
     *
     * @var array
     */
    protected $hidden = [
    ];


    /**
     * The attributes that should be append for arrays
     *
     * @var array
     */
    protected $appends = [
    ];


    protected $casts = [
        'params' => 'array'
    ];


    public static function boot()
    {
        self::traitBoot();
    }

}
