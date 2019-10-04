<?php

namespace DaydreamLab\Media\Services\Media\Front;

use DaydreamLab\Media\Repositories\Media\Front\MediaFrontRepository;
use DaydreamLab\Media\Services\Media\MediaService;

class MediaFrontService extends MediaService
{
    protected $type = 'MediaFront';

    public function __construct(MediaFrontRepository $repo)
    {
        parent::__construct($repo);
    }
}
