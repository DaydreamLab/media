<?php

namespace DaydreamLab\Media\Controllers\Media;

use DaydreamLab\JJAJ\Controllers\BaseController;
use DaydreamLab\Media\Services\Media\MediaService;


class MediaController extends BaseController
{
    public function __construct(MediaService $service)
    {
        parent::__construct($service);
    }

}
