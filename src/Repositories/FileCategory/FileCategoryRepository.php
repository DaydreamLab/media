<?php

namespace DaydreamLab\Media\Repositories\FileCategory;

use DaydreamLab\Media\Models\FileCategory\FileCategory;
use DaydreamLab\Media\Repositories\MediaRepository;

class FileCategoryRepository extends MediaRepository
{
    protected $modelName = 'FileCategory';

    public function __construct(FileCategory $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function getByContentTypeAndExtension($contentType, $extension = null)
    {
        return $this->model->where('contentType', $contentType)->where('extension', $extension)->get();
    }
}
