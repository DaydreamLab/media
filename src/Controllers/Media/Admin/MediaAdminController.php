<?php

namespace DaydreamLab\Media\Controllers\Media\Admin;

use DaydreamLab\JJAJ\Controllers\BaseController;
use DaydreamLab\JJAJ\Helpers\Helper;
use DaydreamLab\JJAJ\Helpers\ResponseHelper;
use DaydreamLab\Media\Requests\Media\Admin\MediaAdminCreateFolderPost;
use DaydreamLab\Media\Requests\Media\Admin\MediaAdminGetFoldersPost;
use DaydreamLab\Media\Requests\Media\Admin\MediaAdminDeletePost;
use DaydreamLab\Media\Requests\Media\Admin\MediaAdminGetFolderItemsPost;
use DaydreamLab\Media\Requests\Media\Admin\MediaAdminMovePost;
use DaydreamLab\Media\Requests\Media\Admin\MediaAdminRenamePost;
use DaydreamLab\Media\Requests\Media\Admin\MediaAdminUploadPost;
use DaydreamLab\Media\Services\Media\Admin\MediaAdminService;
use Illuminate\Http\Request;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;

class MediaAdminController extends BaseController
{
    protected $package = 'Media';

    protected $modelName = 'Media';

    protected $modelType = 'Admin';


    public function __construct(MediaAdminService $service)
    {
        parent::__construct($service);
        $this->service = $service;
    }


    public function createFolder(MediaAdminCreateFolderPost $request)
    {
        $this->service->setUser($request->user());
        $this->service->createFolder($request->validated());

        return $this->response($this->service->status, $this->service->response);
    }


    public function getAllFolders(MediaAdminGetFoldersPost $request)
    {
        $this->service->setUser($request->user());
        $this->service->getAllFolders();

        return $this->response($this->service->status, $this->service->response);
    }


    public function getFolderItems(MediaAdminGetFolderItemsPost $request)
    {
        $this->service->setUser($request->user());
        $this->service->getFolderItems($request->validated());

        return $this->response($this->service->status, $this->service->response);
    }


    public function move(MediaAdminMovePost $request)
    {
        $this->service->setUser($request->user());
        $this->service->move($request->validated());

        return $this->response($this->service->status, $this->service->response);
    }


    public function remove(MediaAdminDeletePost $request)
    {
        $this->service->setUser($request->user());
        $this->service->remove($request->validated());

        return $this->response($this->service->status, $this->service->response);
    }


    public function rename(MediaAdminRenamePost $request)
    {
        $this->service->setUser($request->user());
        $this->service->rename($request->validated());

        return $this->response($this->service->status, $this->service->response);
    }


    public function upload(MediaAdminUploadPost $request)
    {
        $this->service->setUser($request->user());
        $this->service->upload($request->validated());

        return $this->response($this->service->status, $this->service->response);
    }
}
