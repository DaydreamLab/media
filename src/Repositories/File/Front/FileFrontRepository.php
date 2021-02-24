<?php

namespace DaydreamLab\Media\Repositories\File\Front;

use DaydreamLab\Media\Models\File\Front\FileFront;
use DaydreamLab\Media\Repositories\File\FileRepository;

class FileFrontRepository extends FileRepository
{
    protected $modelType = 'Front';

    public function __construct(FileFront $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
}