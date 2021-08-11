<?php

namespace DaydreamLab\Media\Services\File;

use DaydreamLab\Media\Repositories\MediaRepository;
use DaydreamLab\Media\Services\MediaService;
use DaydreamLab\Media\Traits\Service\AzureBlob;
use Illuminate\Support\Collection;

class FileService extends MediaService
{
    use AzureBlob;

    protected $modelName = 'File';

    protected $modelType = 'Base';

    protected $provider;


    public function __construct(MediaRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }


    public function add(Collection $input)
    {
        $item = parent::add($input);

        //event(new Add($item, $this->model_name, $input, $this->user));

        return $item;
    }


    public function getProvider()
    {
        if (!$this->provider) {
            $this->provider = config('daydreamlab.media.file.provider');
        }

        return $this->provider;
    }


    public function modify(Collection $input)
    {
        $result =  parent::modify($input);

        //event(new Modify($this->find($input->id), $this->model_name, $result, $input, $this->user));

        return $result;
    }


    public function ordering(Collection $input)
    {
        $result = parent::ordering($input);

        //event(new Ordering($this->model_name, $result, $input, $orderingKey, $this->user));

        return $result;
    }


    public function remove(Collection $input)
    {
        $result =  parent::remove($input);

        //event(new Remove($this->model_name, $result, $input, $this->user));

        return $result;
    }


    public function state(Collection $input)
    {
        $result = parent::state($input);

        //event(new State($this->model_name, $result, $input, $this->user));

        return $result;
    }
}
