<?php

namespace DaydreamLab\Media\Services\File\Front;

use DaydreamLab\JJAJ\Exceptions\ForbiddenException;
use DaydreamLab\JJAJ\Exceptions\InternalServerErrorException;
use DaydreamLab\JJAJ\Exceptions\NotFoundException;
use DaydreamLab\Media\Repositories\File\Front\FileFrontRepository;
use DaydreamLab\Media\Services\File\FileService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class FileFrontService extends FileService
{
    public function __construct(FileFrontRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }


    public function download(Collection $input)
    {
        $item = $this->findBy('uuid', '=', $input->get('uuid'))->first();
        if (!$item) {
            throw new NotFoundException('ItemNotExist', ['uuid' =>  $input->get('uuid')], null, $this->modelName);
        }

        if ($item->password) {
            if(!Hash::check($input->get('password'), $item->password)) {
                throw new ForbiddenException('PasswordIncorrect');
            }
        }

        // todo: 判斷權限
        $this->response = $item;

        if ($this->getProvider() == 'azure') {
            $client = $this->getAzureClient();
            try {
                $blob = $client->getBlob($this->azureContainer, $item->blobName);
            } catch (\Throwable $t) {
                if ($t->getCode() == 404) {
                    throw new NotFoundException('BlobNotFound', 404);
                } else {
                    throw new InternalServerErrorException('BlobError', 500);
                }
            }

            return $blob;
        }
    }
}
