<?php

namespace DaydreamLab\Media\Repositories\Media\Front;

use DaydreamLab\Media\Repositories\Media\MediaRepository;
use DaydreamLab\Media\Models\Media\Front\MediaFront;

class MediaFrontRepository extends MediaRepository
{
    public function __construct(MediaFront $model)
    {
        parent::__construct($model);
    }
}