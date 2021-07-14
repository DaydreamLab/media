<?php

namespace DaydreamLab\Media\Controllers\FileCategory\Admin;

use DaydreamLab\Media\Controllers\MediaController;
use DaydreamLab\Media\Requests\FileCategory\Admin\FileCategoryAdminGetItemRequest;
use DaydreamLab\Media\Requests\FileCategory\Admin\FileCategoryAdminRemoveRequest;
use DaydreamLab\Media\Requests\FileCategory\Admin\FileCategoryAdminRestoreRequest;
use DaydreamLab\Media\Requests\FileCategory\Admin\FileCategoryAdminSearchRequest;
use DaydreamLab\Media\Requests\FileCategory\Admin\FileCategoryAdminStateRequest;
use DaydreamLab\Media\Requests\FileCategory\Admin\FileCategoryAdminStoreRequest;
use DaydreamLab\Media\Resources\FileCategory\Admin\Collections\FileCategoryAdminListResourceCollection;
use DaydreamLab\Media\Resources\FileCategory\Admin\Models\FileCategoryAdminResource;
use DaydreamLab\Media\Services\FileCategory\Admin\FileCategoryAdminService;
use Throwable;

class FileCategoryAdminController extends MediaController
{
    protected $modelName = 'FileCategory';

    public function __construct(FileCategoryAdminService $service)
    {
        parent::__construct($service);
        $this->service = $service;
    }

    public function getItem(FileCategoryAdminGetItemRequest $request)
    {
        $this->service->setUser($request->user('api'));
        try {
            $this->service->getItem(collect(['id' => $request->route('id')]));
        } catch (Throwable $t) {
            $this->handleException($t);
        }

        return $this->response($this->service->status, $this->service->response, [], FileCategoryAdminResource::class);
    }


    public function remove(FileCategoryAdminRemoveRequest $request)
    {
        $this->service->setUser($request->user('api'));
        try {
            $this->service->remove($request->validated());
        } catch (Throwable $t) {
            $this->handleException($t);
        }

        return $this->response($this->service->status, $this->service->response);
    }


    public function restore(FileCategoryAdminRestoreRequest $request)
    {
        $this->service->setUser($request->user('api'));
        try {
            $this->service->restore($request->validated());
        } catch (Throwable $t) {
            $this->handleException($t);
        }

        return $this->response($this->service->status, $this->service->response);
    }


    public function search(FileCategoryAdminSearchRequest $request)
    {
        $this->service->setUser($request->user('api'));
        try {
            $this->service->search($request->validated());
        } catch (Throwable $t) {
            $this->handleException($t);
        }

        return $this->response($this->service->status, $this->service->response, [], FileCategoryAdminListResourceCollection::class);
    }


    public function state(FileCategoryAdminStateRequest $request)
    {
        $this->service->setUser($request->user('api'));
        try {
            $this->service->state($request->validated());
        } catch (Throwable $t) {
            $this->handleException($t);
        }

        return $this->response($this->service->status, $this->service->response);
    }


    public function store(FileCategoryAdminStoreRequest $request)
    {
        $this->service->setUser($request->user('api'));
        try {
            $this->service->store($request->validated());
        } catch (Throwable $t) {
            $this->handleException($t);
        }

        return $this->response($this->service->status, $this->service->response, [], FileCategoryAdminResource::class);
    }

}
