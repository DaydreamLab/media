<?php

namespace DaydreamLab\Media\Controllers\Media\Front;

use DaydreamLab\JJAJ\Controllers\BaseController;
use DaydreamLab\Media\Services\Media\Front\MediaFrontService;


class MediaFrontController extends BaseController
{
    public function __construct(MediaFrontService $service)
    {
        parent::__construct($service);
    }

}
