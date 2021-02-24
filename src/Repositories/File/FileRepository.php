<?php

namespace DaydreamLab\Media\Repositories\File;

use DaydreamLab\Media\Models\File\File;
use DaydreamLab\Media\Repositories\MediaRepository;

class FileRepository extends MediaRepository
{
    protected $modelName = 'File';

    protected $modelType = 'Base';

    public function __construct(File $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
}