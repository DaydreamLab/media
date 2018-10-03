<?php

namespace DaydreamLab\Media\Repositories\Media\Admin;

use DaydreamLab\Media\Repositories\Media\MediaRepository;
use DaydreamLab\Media\Models\Media\Admin\MediaAdmin;

class MediaAdminRepository extends MediaRepository
{
    public function __construct(MediaAdmin $model)
    {
        parent::__construct($model);
    }
}