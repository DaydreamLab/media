<?php

namespace DaydreamLab\Media\Services\File\Front;

use DaydreamLab\Media\Repositories\File\Front\FileFrontRepository;
use DaydreamLab\Media\Services\File\FileService;

class FileFrontService extends FileService
{
    protected $modelType = 'Front';

    public function __construct(FileFrontRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
}
