<?php

namespace DaydreamLab\Media\Services\Media\Admin;

use DaydreamLab\Media\Repositories\Media\Admin\MediaAdminRepository;
use DaydreamLab\Media\Services\Media\MediaService;

class MediaAdminService extends MediaService
{
    protected $type = 'MediaAdmin';

    public function __construct(MediaAdminRepository $repo)
    {
        parent::__construct($repo);
    }
}
