<?php

namespace DaydreamLab\Media\Controllers\File\Admin;

use DaydreamLab\JJAJ\Controllers\BaseController;
use DaydreamLab\JJAJ\Helpers\Helper;
use DaydreamLab\Media\Requests\File\Admin\FileAdminGetItem;
use DaydreamLab\Media\Requests\File\Admin\FileAdminRemovePost;
use DaydreamLab\Media\Requests\File\Admin\FileAdminSearchPost;
use DaydreamLab\Media\Requests\File\Admin\FileAdminStatePost;
use DaydreamLab\Media\Requests\File\Admin\FileAdminStorePost;
use DaydreamLab\Media\Resources\File\Admin\Models\FileAdminResource;
use DaydreamLab\Media\Services\File\Admin\FileAdminService;

class FileAdminController extends BaseController
{
    protected $modelName = 'File';

    protected $modelType = 'Admin';

    public function __construct(FileAdminService $service)
    {
        parent::__construct($service);
        $this->service = $service;
    }


    public function getItem(FileAdminGetItem $request)
    {
        $this->service->setUser($request->user('api'));
        $this->service->getItem(collect(['id' => $request->route('id')]));

        return $this->response($this->service->status, new FileAdminResource($this->service->response));
    }


    public function remove(FileAdminRemovePost $request)
    {
        $this->service->setUser($request->user('api'));
        $this->service->remove($request->validated());

        return $this->response($this->service->status, $this->service->response);
    }


    public function state(FileAdminStatePost $request)
    {
        $this->service->setUser($request->user('api'));
        $this->service->state($request->validated());

        return $this->response($this->service->status, $this->service->response);
    }


    public function store(FileAdminStorePost $request)
    {
        Helper::show($request->file);
        exit();
        $this->service->setUser($request->user('api'));
        $this->service->store($request->validated());

        return $this->response($this->service->status,
            gettype($this->service->response) == 'object'
            ? new FileAdminResource($this->service->response)
            : $this->service->response
        );
    }


    public function search(FileAdminSearchPost $request)
    {
        $this->service->setUser($request->user('api'));
        $this->service->search($request->validated());

        return $this->response($this->service->status, $this->service->response);
    }
}
