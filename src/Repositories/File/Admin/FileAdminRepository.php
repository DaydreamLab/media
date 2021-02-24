<?php

namespace DaydreamLab\Media\Repositories\File\Admin;

use DaydreamLab\Media\Models\File\Admin\FileAdmin;
use DaydreamLab\Media\Repositories\File\FileRepository;

class FileAdminRepository extends FileRepository
{
    protected $modelType = 'Admin';

    public function __construct(FileAdmin $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
}