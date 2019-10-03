<?php

namespace DaydreamLab\Media\Controllers\Media\Admin;

use DaydreamLab\JJAJ\Controllers\BaseController;
use DaydreamLab\JJAJ\Helpers\Helper;
use DaydreamLab\JJAJ\Helpers\ResponseHelper;
use DaydreamLab\Media\Requests\Media\Admin\MediaAdminCreateFolderPost;
use DaydreamLab\Media\Requests\Media\Admin\MediaAdminDeletePost;
use DaydreamLab\Media\Requests\Media\Admin\MediaAdminGetFolderItemsPost;
use DaydreamLab\Media\Requests\Media\Admin\MediaAdminMovePost;
use DaydreamLab\Media\Requests\Media\Admin\MediaAdminRenamePost;
use DaydreamLab\Media\Requests\Media\Admin\MediaAdminUploadPost;
use DaydreamLab\Media\Services\Media\Admin\MediaAdminService;


class MediaAdminController extends BaseController
{
    public function __construct(MediaAdminService $service)
    {
        parent::__construct($service);
        $this->service = $service;
    }


    public function createFolder(MediaAdminCreateFolderPost $request)
    {
        $this->service->canAction('createFolder');
        $this->service->createFolder($request->rulesInput());

        return ResponseHelper::response($this->service->status, $this->service->response);
    }


    public function getAllFolders()
    {
        $this->service->canAction('getAllFolder');
        $this->service->getAllFolders();

        return ResponseHelper::response($this->service->status, $this->service->response);
    }


    public function getFolderItems(MediaAdminGetFolderItemsPost $request)
    {
        $this->service->canAction('getFolderItems');
        $this->service->getFolderItems($request->rulesInput());

        return ResponseHelper::response($this->service->status, $this->service->response);
    }


    public function move(MediaAdminMovePost $request)
    {
        $this->service->canAction('move');
        $this->service->move($request->rulesInput());

        return ResponseHelper::response($this->service->status, $this->service->response);
    }


    public function remove(MediaAdminDeletePost $request)
    {
        $this->service->canAction('delete');
        $this->service->remove($request->rulesInput());

        return ResponseHelper::response($this->service->status, $this->service->response);
    }


    public function rename(MediaAdminRenamePost $request)
    {
        $this->service->canAction('rename');
        $this->service->rename($request->rulesInput());

        return ResponseHelper::response($this->service->status, $this->service->response);
    }


    public function upload(MediaAdminUploadPost $request)
    {
        $this->service->canAction('add');
        $this->service->upload($request->rulesInput());

        return ResponseHelper::response($this->service->status, $this->service->response);
    }
}
