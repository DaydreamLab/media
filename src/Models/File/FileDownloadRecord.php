<?php

namespace DaydreamLab\Media\Models\File;

use DaydreamLab\Media\Models\MediaModel;
use DaydreamLab\User\Models\User\User;
use Illuminate\Support\Str;

class FileDownloadRecord extends MediaModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'files_download_records';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fileId',
        'userId'
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



    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }
}
