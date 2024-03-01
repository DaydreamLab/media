<?php

namespace DaydreamLab\Media\Services\Media;

use DaydreamLab\Media\Repositories\Media\MediaRepository;
use DaydreamLab\JJAJ\Services\BaseService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use DaydreamLab\JJAJ\Traits\LoggedIn;

class MediaService extends BaseService
{
    use LoggedIn;

    protected $type = 'Media';

    protected $media_storage = null;

    protected $thumb_storage = null;

    protected $media_storage_type = 'media-public';

    protected $thumb_storage_type = 'media-thumb';

    protected $media_path = null;

    protected $media_link_base = '/storage/media';

    protected $thumb_path = null;

    protected $userMerchantID = null;

    protected $modelName = 'Media';

    protected $modelType = 'Base';

    public function __construct(MediaRepository $repo)
    {
        parent::__construct($repo);

        $this->media_storage = Storage::disk($this->media_storage_type);
        $this->thumb_storage = Storage::disk($this->thumb_storage_type);
        $this->media_path    = $this->media_storage->path('');
        $this->thumb_path    = $this->thumb_storage->path('');
    }


    public function exist(Collection $input)
    {
        return $this->media_storage->exists($input->dir . '/' . $input->name) &&
            $this->thumb_storage->exists($input->dir . '/' . $input->name) ?: false;
    }


    public function deleteStorage($old, $new)
    {
        return $this->media_storage->move($old, $new) &&
        $this->thumb_storage->move($old, $new) ?: false;
    }


    public function moveStorage($old, $new)
    {
        return $this->media_storage->move($old, $new) &&
                $this->thumb_storage->move($old, $new) ?: false;
    }
}
