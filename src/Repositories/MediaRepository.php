<?php

namespace DaydreamLab\Media\Repositories;

use DaydreamLab\JJAJ\Models\BaseModel;
use DaydreamLab\JJAJ\Repositories\BaseRepository;

abstract class MediaRepository extends BaseRepository
{
    protected $package = 'Media';

    public function __construct(BaseModel $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
}