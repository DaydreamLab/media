<?php

namespace DaydreamLab\Media\Controllers;

use DaydreamLab\JJAJ\Controllers\BaseController;
use DaydreamLab\JJAJ\Services\BaseService;

abstract class MediaController extends BaseController
{
    protected $package = 'Media';

    public function __construct(BaseService $service)
    {
        parent::__construct($service);
        $this->service = $service;
    }
}