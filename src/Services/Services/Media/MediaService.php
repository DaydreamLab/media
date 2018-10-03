<?php

namespace DaydreamLab\Media\Services\Media;

use DaydreamLab\JJAJ\Helpers\Helper;
use DaydreamLab\Media\Repositories\Media\MediaRepository;
use DaydreamLab\JJAJ\Services\BaseService;
use Illuminate\Support\Collection;

class MediaService extends BaseService
{
    protected $type = 'Media';

    public function __construct(MediaRepository $repo)
    {
        parent::__construct($repo);
    }


    public function upload(Collection $input)
    {
        Helper::show($input);
    }
}
