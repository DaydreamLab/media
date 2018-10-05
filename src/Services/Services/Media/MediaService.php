<?php

namespace DaydreamLab\Media\Services\Media;

use DaydreamLab\Media\Repositories\Media\MediaRepository;
use DaydreamLab\JJAJ\Services\BaseService;
use Illuminate\Support\Facades\Storage;

class MediaService extends BaseService
{
    protected $type = 'Media';

    protected $media_storage = null;

    protected $thumb_storage = null;

    protected $media_storage_type = 'media-public';

    protected $thumb_storage_type = 'media-thumb';

    public function __construct(MediaRepository $repo)
    {
        $this->media_storage = Storage::disk($this->media_storage_type);
        $this->thumb_storage = Storage::disk($this->thumb_storage_type);
        parent::__construct($repo);
    }



}
