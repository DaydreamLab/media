<?php

namespace DaydreamLab\Media\Services\File\Front;

use DaydreamLab\JJAJ\Helpers\Helper;
use DaydreamLab\Media\Repositories\File\Front\FileFrontRepository;
use DaydreamLab\Media\Services\File\FileService;
use Illuminate\Support\Collection;

class FileFrontService extends FileService
{
    protected $modelType = 'Front';

    public function __construct(FileFrontRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }


    public function download(Collection $input)
    {
        $item = $this->findBy('uuid', '=', $input->get('uuid'))->first();
        if (!$item) {
            $this->throwResponse('ItemNotExist');
        }

        // todo: 判斷權限
        $this->response = $item;

        if ($this->getProvider() == 'azure') {
            $client = $this->getAzureClient();
            $blob =  $client->getBlob($this->azureContainer, $item->blobName);
            return $blob;
        }
    }
}
