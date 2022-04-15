<?php

namespace DaydreamLab\Media\Services\File\Admin;

use DaydreamLab\JJAJ\Exceptions\ForbiddenException;
use DaydreamLab\JJAJ\Exceptions\NotFoundException;
use DaydreamLab\JJAJ\Traits\FormatFileSize;
use DaydreamLab\JJAJ\Traits\LoggedIn;
use DaydreamLab\Media\Models\File\FileDownloadRecord;
use DaydreamLab\Media\Repositories\File\Admin\FileAdminRepository;
use DaydreamLab\Media\Repositories\FileCategory\Admin\FileCategoryAdminRepository;
use DaydreamLab\Media\Services\File\FileService;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use MicrosoftAzure\Storage\Blob\Models\CreateBlockBlobOptions;

class FileAdminService extends FileService
{
    use LoggedIn, FormatFileSize;

    protected $fileCategoryAdminRepository;

    public function __construct(FileAdminRepository $repo, FileCategoryAdminRepository $fileCategoryAdminRepository)
    {
        parent::__construct($repo);
        $this->repo = $repo;
        $this->fileCategoryAdminRepository = $fileCategoryAdminRepository;
    }


    public function add(Collection $input)
    {/*
        if ($password = $input->get('password')) {
            $input->put('password', bcrypt($password));
        }
*/
        $file = parent::add($input);
  /*      if ( $notifyEmails = $input->get('notifyEmails') ) {
            $notifyEmails = explode(';', $notifyEmails);
            #todo: 寄送 email 訊息
        }
*/
        return $this->response;
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
        # 上傳時同時新增檔案，先找出檔案分類
        if ($input->get('createFile')) {
            $category = $this->fileCategoryAdminRepository->search($input->only('q'))->first();
            if (!$category) {
                throw new NotFoundException('ItemNotExist', [
                    'contentType' => $input->get('contentType'),
                    'extension'   => $input->get('extension')
                ], null, 'FileCategory');
            }
        }

        $files = collect();
        foreach ($input->get('files') ?:[] as $inputFile) {
            $filename = pathinfo($inputFile->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = pathinfo($inputFile->getClientOriginalName(), PATHINFO_EXTENSION);
            if ($input->get('isBackUp')) {
                $blobName = $input->get('dir') . '/' . $inputFile->getClientOriginalName();
            } else {
                $blobName = Str::random(5) . '.' . $inputFile->getClientOriginalName();
            }

            $contentType = $inputFile->getClientMimeType();
            $client = $this->getAzureClient();
            $url = $this->baseUrl . $blobName;
            $options = new CreateBlockBlobOptions();
            $options->setContentType($contentType);

            $content = fopen(is_string($inputFile) ? $inputFile : $inputFile->getRealPath(), 'r');
            $client->createBlockBlob($this->azureContainer, $blobName, $content, $options);
            if (is_resource($content)) {
                fclose($content);
            }

            if ($input->get('createFile')) {
                $addData = collect([
                    'name'          => $filename,
                    'category_id'   => $category->id,
                    'state'         => 1,
                    'blobName'      => $blobName,
                    'contentType'   => $contentType,
                    'extension'     => $extension,
                    'size'          => $this->formatFileSize($inputFile->getSize()),
                    'url'           => $url,
                    'userGroupId'   => 7,
                    //'encrypted'     => 0,
                    'params'        => ['upload' => 'file']
                ]);
                $file = $this->store($addData);
            } else {
                $file = collect([
                    'name'          => $filename,
                    'blobName'      => $blobName,
                    'contentType'   => $contentType,
                    'extension'     => $extension,
                    'size'          => $this->formatFileSize($inputFile->getSize()),
                    'url'           => $url,
                ]);
            }
            $files->push($file);
        }

        return $files;
    }


    public function beforeRemove(Collection $input, $item)
    {
        $this->deleteUpload($item->blobName);
    }


    public function deleteUpload($blobName)
    {
        if ($this->getProvider() == 'azure') {
            $error = false;
            $errorResponse = null;
            $client = $this->getAzureClient();
            try {
                $client->deleteBlob($this->azureContainer, $blobName);
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

            $this->status = 'DeleteAzureSuccess';
        }

        return $this->response;
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


    public function search(Collection $input)
    {
        $contentType = $input->get('contentType');
        if ( $contentType ) {
            $q = $input->get('q');
            $fcs = $this->fileCategoryAdminRepository->getByContentTypeAndExtension($contentType);
            $fcIds = $fcs->pluck(['id']);
            $q = $q->whereIn('category_id', $fcIds);
            $input->put('q', $q);
        }
        $input->forget('contentType');

        return parent::search($input);
    }


    public function searchDownload(Collection $input)
    {
        $records = FileDownloadRecord::where('fileId', $input->get('fileId'))->orderByDesc('id')->get();
        $records = $records->map(function ($r) {
            if ($user = $r->user) {
                return [
                    'company' => $user->company->name,
                    'name'  => $user->name,
                    'mobilePhone' => $user->mobilePhone,
                    'email' => $user->email,
                    'group' => $user->groups->first()->title
                ];
            } else {
                return [
                    'company' => '',
                    'name'  => '',
                    'mobilePhone' => '',
                    'email' => '',
                    'group' => '訪客'
                ];
            }
        });
        $this->status = 'SearchSuccess';
        $p = $this->repo->paginate($records, $input->get('limit'), $input->get('page'))->toArray();
        $data = $p['data'];
        unset($p['data']);
        $this->response = collect(['items' => $data, 'pagination' => $p]);

        return $this->response;
    }


    public function store(Collection $input)
    {
        $category = $this->fileCategoryAdminRepository->find($input->get('category_id'));
        if (!$category) {
            throw new NotFoundException('ItemNotExist', [
                'categoryId' => (int)$input->get('category_id')
            ], null, 'FileCategory');
        }

        if ($input->get('uuid') == '') {
            $input->put('uuid', 'F' . now('Asia/Taipei')->format('ym') . Str::random(3));
        }

        $result = parent::store($input);
        if ($input->has('id')) {
            $result = $this->find($input->get('id'));
        }
        $this->response = $result;

        return $this->response;
    }



    public function upload(Collection $input)
    {
        $provider = $this->getProvider();
        if ($provider == 'azure') {
            $result = $this->addAzure($input);
            $this->status = 'UploadAzureSuccess';
            $this->response = $result;
        }

        return $this->response;
    }
}
