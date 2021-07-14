<?php

namespace DaydreamLab\Media\Controllers\File\Admin;

use DaydreamLab\JJAJ\Controllers\BaseController;
use DaydreamLab\Media\Requests\File\Admin\FileAdminGetItem;
use DaydreamLab\Media\Requests\File\Admin\FileAdminRemovePost;
use DaydreamLab\Media\Requests\File\Admin\FileAdminSearchPost;
use DaydreamLab\Media\Requests\File\Admin\FileAdminStatePost;
use DaydreamLab\Media\Requests\File\Admin\FileAdminStorePost;
use DaydreamLab\Media\Resources\File\Admin\Models\FileAdminResource;
use DaydreamLab\Media\Services\File\Admin\FileAdminService;
use Throwable;

class FileAdminController extends BaseController
{
    protected $package = 'Media';

    protected $modelName = 'File';

    public function __construct(FileAdminService $service)
    {
        parent::__construct($service);
        $this->service = $service;
    }


    public function getItem(FileAdminGetItem $request)
    {
        $this->service->setUser($request->user('api'));
        try {
            $this->service->getItem(collect(['id' => $request->route('id')]));
        } catch (Throwable $t) {
            $this->handleException($t);
        }

        return $this->response($this->service->status, $this->service->response, [], FileAdminResource::class);
    }


    public function remove(FileAdminRemovePost $request)
    {
        $this->service->setUser($request->user('api'));
        try {
            $this->service->remove($request->validated());
        } catch (Throwable $t) {
            $this->handleException($t);
        }

        return $this->response($this->service->status, $this->service->response);
    }


    public function state(FileAdminStatePost $request)
    {
        $this->service->setUser($request->user('api'));
        try {
            $this->service->state($request->validated());
        } catch (Throwable $t) {
            $this->handleException($t);
        }

        return $this->response($this->service->status, $this->service->response);
    }


    public function store(FileAdminStorePost $request)
    {
        $this->service->setUser($request->user('api'));
        try {
            $this->service->store($request->validated());
        } catch (Throwable $t) {
            $this->handleException($t);
        }

        return $this->response($this->service->status, $this->service->response, [], FileAdminResource::class);
    }


    public function search(FileAdminSearchPost $request)
    {
        $this->service->setUser($request->user('api'));
        try {
            $this->service->search($request->validated());
        } catch (Throwable $t) {
            $this->handleException($t);
        }

        return $this->response($this->service->status, $this->service->response);
    }
}
