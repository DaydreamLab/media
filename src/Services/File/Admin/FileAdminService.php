<?php

namespace DaydreamLab\Media\Services\File\Admin;

use DaydreamLab\JJAJ\Traits\LoggedIn;
use DaydreamLab\Media\Repositories\File\Admin\FileAdminRepository;
use DaydreamLab\Media\Services\File\FileService;

class FileAdminService extends FileService
{
    use LoggedIn;

    protected $modelType = 'Admin';

    public function __construct(FileAdminRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
}
