<?php

namespace DaydreamLab\Media\Services\File\Admin;

use DaydreamLab\JJAJ\Helpers\Helper;
use DaydreamLab\JJAJ\Traits\LoggedIn;
use DaydreamLab\Media\Repositories\File\Admin\FileAdminRepository;
use DaydreamLab\Media\Services\File\FileService;
use DaydreamLab\User\Services\User\Admin\UserGroupAdminService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use MicrosoftAzure\Storage\Blob\Models\CreateBlockBlobOptions;

class FileAdminService extends FileService
{
    use LoggedIn;

    protected $modelType = 'Admin';

    protected $search_keys = ['name'];

    protected $userGroupAdminService;

    public function __construct(FileAdminRepository $repo, UserGroupAdminService $userGroupAdminService)
    {
        parent::__construct($repo);
        $this->repo = $repo;
        $this->userGroupAdminService = $userGroupAdminService;
    }


    public function add(Collection $input)
    {
        if ($password = $input->get('password')) {
            $input->put('password', bcrypt($password));
        }

        $provider = $this->getProvider();
        if ($provider == 'azure') {
            $result = $this->addAzure($input);
            if (count($notifyEmails = $input->get('notifyEmails'))) {
                #todo: 寄送 email 訊息
            }
        } elseif ($provider == 'aws') {

        } else {

        }

        return $result;
    }


    public function addAzure(Collection $input)
    {
        $blobName = $input->get('name') ;
        $duplicate = $this->findBy('name', '=', $input->get('name'))->count();
        if ($duplicate) {
            $copy = $this->findBy('name', 'like', "%{$input->get('name')}.%")->count();
            $blobName .= '.' . ($copy + 2) . '.' . $input->get('extension');
            $input->put('name', $input->get('name') . '.' . ($copy + 2));
        } else {
            $blobName .= '.' . $input->get('extension');
        }

        $client = $this->getAzureClient();
        $input->put('url', $this->baseUrl . $blobName);
        $options = new CreateBlockBlobOptions();
        $options->setContentType($input->get('contentType'));

        $file = $input->get('file');
        $content = fopen(is_string($file) ? $file : $file->getRealPath(), 'r');
        $client->createBlockBlob($this->azureContainer, $blobName, $content, $options);
        if (is_resource($content)) {
            fclose($content);
        }

        $item = parent::add($input);

        return $item;
    }


    public function addAws(Collection $input)
    {

    }


    public function beforeRemove(Collection $input, $item)
    {
        if ($this->getProvider() == 'azure') {
            $error = false;
            $errorResponse = null;
            $client = $this->getAzureClient();
            try {
                $client->deleteBlob($this->azureContainer, $item->blobName);
            } catch (\Throwable $throwable) {
                preg_match('#<Code>(.*?)</Code>#', $throwable->getMessage(), $errorResponse);
                $error = true;
            }

            if ($error) {
                $errorMessage = count($errorResponse)
                    ? $errorResponse[1]
                    : 'BlobError';
                $this->throwResponse($errorMessage);
            }
        }
    }
}
