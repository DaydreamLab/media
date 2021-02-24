<?php

namespace DaydreamLab\Media\Services;

use DaydreamLab\JJAJ\Repositories\BaseRepository;
use DaydreamLab\JJAJ\Services\BaseService;
use Illuminate\Support\Collection;

abstract class MediaService extends BaseService
{
    protected $package = 'Media';

    public function __construct(BaseRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
}
