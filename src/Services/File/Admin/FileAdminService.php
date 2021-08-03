<?php

namespace DaydreamLab\Media\Services\File\Admin;

use DaydreamLab\JJAJ\Exceptions\ForbiddenException;
use DaydreamLab\JJAJ\Exceptions\NotFoundException;
use DaydreamLab\JJAJ\Traits\LoggedIn;
use DaydreamLab\Media\Repositories\File\Admin\FileAdminRepository;
use DaydreamLab\Media\Repositories\FileCategory\Admin\FileCategoryAdminRepository;
use DaydreamLab\Media\Services\File\FileService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use MicrosoftAzure\Storage\Blob\Models\CreateBlockBlobOptions;

class FileAdminService extends FileService
{
    use LoggedIn;

    protected $fileCategoryAdminRepository;

    public function __construct(FileAdminRepository $repo, FileCategoryAdminRepository $fileCategoryAdminRepository)
    {
        parent::__construct($repo);
        $this->repo = $repo;
        $this->fileCategoryAdminRepository = $fileCategoryAdminRepository;
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


    public function addMapping($item, $input)
    {
        $tags = $input->get('tags') ? $input->get('tags') : [];
        $tagIds = array_map(function($tag) {
            return $tag['id'];
        }, $tags);
        if (count($tagIds)) {
            $item->tags()->attach($tagIds);
        }

        $brands = $input->get('brands') ? $input->get('brands') : [];
        $brand_ids = array_map(function($brand) {
            return $brand['id'];
        }, $brands);
        if (count($brand_ids)) {
            $item->brands()->attach($brand_ids);
        }
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

                throw new ForbiddenException($errorMessage);
            }
        }
    }


    public function modifyMapping($item, $input)
    {
        if ( $input->get('tags') !== null ) {
            $tagIds = array_map(function($tag) {
                return $tag['id'];
            }, $input->get('tags'));
            $item->tags()->sync($tagIds);
        }

        if ( $input->get('brands') !== null ) {
            $brand_ids = array_map(function($brand) {
                return $brand['id'];
            }, $input->get('brands'));
            $item->brands()->sync($brand_ids);
        }
    }


    public function store(Collection $input)
    {
        $category = $this->fileCategoryAdminRepository->find($input->get('category_id'));
        if (!$category) {
            throw new NotFoundException('ItemNotExist', [
                'categoryId' => (int)$input->get('category_id')
            ], null, 'FileCategory');
        }

        # 如果 file 是 url 形式，先取得 file 再處理一些參數
        $file = $input->get('file');
        if (is_string($file)) {
            if (strpos($file, 'storage/media') !== false) {
                $input->put('file', public_path($file));
                $input->put('contentType', mime_content_type(public_path($file)));
                $input->put('extension', pathinfo(public_path($file), PATHINFO_EXTENSION));
                $input->put('size', ceil((double) (filesize(public_path($file)) / 1024)));
            } else {

            }

        } else {
            $input->put('contentType', $file->getMimeType());
            $input->put('extension', $file->extension());
            $input->put('size', ceil((double) ($file->getSize() / 1024)));
        }

        return parent::store($input);
    }
}
