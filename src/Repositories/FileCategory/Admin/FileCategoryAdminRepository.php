<?php

namespace DaydreamLab\Media\Repositories\FileCategory\Admin;

use DaydreamLab\Media\Models\FileCategory\Admin\FileCategoryAdmin;
use DaydreamLab\Media\Repositories\FileCategory\FileCategoryRepository;

class FileCategoryAdminRepository extends FileCategoryRepository
{
    public function __construct(FileCategoryAdmin $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
}
