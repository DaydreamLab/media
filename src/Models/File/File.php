<?php

namespace DaydreamLab\Media\Models\File;

use DaydreamLab\Cms\Models\Brand\Brand;
use DaydreamLab\Cms\Models\Tag\Tag;
use DaydreamLab\JJAJ\Traits\UserInfo;
use DaydreamLab\JJAJ\Traits\RecordChanger;
use DaydreamLab\Media\Models\FileCategory\FileCategory;
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
        'blobName',
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
        'password'
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

        static::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }


    public function category()
    {
        return $this->belongsTo(FileCategory::class, 'category_id', 'id');
    }


    public function getDownloadLinkAttribute()
    {
        return config('app.url').'/api/file/download/'.$this->uuid;
    }


    public function groups()
    {
        return $this->belongsToMany(UserGroup::class, 'files_users_groups_maps', 'file_id', 'group_id');
    }


    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'brands_files_maps', 'file_id', 'brand_id')
            ->withTimestamps();
    }


    public function tags()
    {
        return $this->belongsTo(Tag::class, 'files_tags_maps', 'file_id', 'tag_id');
    }
}
