<?php

namespace DaydreamLab\Media\Repositories\Media;

use DaydreamLab\JJAJ\Repositories\BaseRepository;
use DaydreamLab\Media\Models\Media\Media;

class MediaRepository extends BaseRepository
{
    public function __construct(Media $model)
    {
        parent::__construct($model);
    }
}