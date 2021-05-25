<?php

namespace DaydreamLab\Media\Models\File;

use DaydreamLab\Cms\Traits\Model\UserInfo;
use DaydreamLab\JJAJ\Traits\RecordChanger;
use DaydreamLab\Media\Models\MediaModel;
use DaydreamLab\User\Models\User\UserGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class File extends MediaModel
{
    use UserInfo, HasFactory, RecordChanger {
        RecordChanger::boot as traitBoot;
    }
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'files';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'category_id',
        'state',
        'contentType',
        'extension',
        'size',
        'url',
        'introtext',
        'description',
        'encrypted',
        'password',
        'access',
        'ordering',
        'created_by',
        'updated_by'
    ];


    /**
     * The attributes that should be hidden for arrays
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];


    /**
     * The attributes that should be append for arrays
     *
     * @var array
     */
    protected $appends = [
    ];


    public static function boot()
    {
        self::traitBoot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }


    public function getBlobNameAttribute()
    {
        return $this->name . '.' . $this->extension;
    }


    public function groups()
    {
        return $this->belongsToMany(UserGroup::class, 'files_users_groups_maps', 'file_id', 'group_id');
    }
}
