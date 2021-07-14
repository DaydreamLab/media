<?php

namespace DaydreamLab\Media\Services\FileCategory\Admin;

use DaydreamLab\JJAJ\Traits\LoggedIn;
use DaydreamLab\Media\Repositories\FileCategory\Admin\FileCategoryAdminRepository;
use DaydreamLab\Media\Services\FileCategory\FileCategoryService;

class FileCategoryAdminService extends FileCategoryService
{
    use LoggedIn;

    public function __construct(FileCategoryAdminRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
}
