<?php

namespace DaydreamLab\Media\Controllers\File;

use DaydreamLab\Media\Controllers\MediaController;
use DaydreamLab\Media\Services\MediaService;

class FileController extends MediaController
{
    protected $modelName = 'File';

    protected $modelType = 'Base';

    public function __construct(MediaService $service)
    {
        parent::__construct($service);
        $this->service = $service;
    }
}