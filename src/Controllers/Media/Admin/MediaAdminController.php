<?php

namespace DaydreamLab\Media\Controllers\Media\Admin;

use DaydreamLab\JJAJ\Controllers\BaseController;
use DaydreamLab\JJAJ\Helpers\Helper;
use DaydreamLab\JJAJ\Helpers\ResponseHelper;
use DaydreamLab\Media\Requests\Media\Admin\MediaAdminCreateFolderPost;
use DaydreamLab\Media\Requests\Media\Admin\MediaAdminDeletePost;
use DaydreamLab\Media\Requests\Media\Admin\MediaAdminGetFolderItemsPost;
use DaydreamLab\Media\Requests\Media\Admin\MediaAdminMovePost;
use DaydreamLab\Media\Requests\Media\Admin\MediaAdminUploadPost;
use DaydreamLab\Media\Services\Media\Admin\MediaAdminService;


class MediaAdminController extends BaseController
{
    public function __construct(MediaAdminService $service)
    {
        parent::__construct($service);
    }


    public function createFolder(MediaAdminCreateFolderPost $request)
    {
        $this->service->createFolder($request->rulesInput());

        return ResponseHelper::response($this->service->status, $this->service->response);
    }


    public function getAllFolders()
    {
        $this->service->getAllFolders();

        return ResponseHelper::response($this->service->status, $this->service->response);
    }


    public function getFolderItems(MediaAdminGetFolderItemsPost $request)
    {
        $this->service->getFolderItems($request->rulesInput());

        return ResponseHelper::response($this->service->status, $this->service->response);
    }


    public function move(MediaAdminMovePost $request)
    {
        $this->service->move($request->rulesInput());

        return ResponseHelper::response($this->service->status, $this->service->response);
    }


    public function remove(MediaAdminDeletePost $request)
    {
        $this->service->remove($request->rulesInput());

        return ResponseHelper::response($this->service->status, $this->service->response);
    }


    public function rename()
    {

    }


    public function upload(MediaAdminUploadPost $request)
    {
        $this->service->upload($request->rulesInput());

        return ResponseHelper::response($this->service->status, $this->service->response);
    }
}
