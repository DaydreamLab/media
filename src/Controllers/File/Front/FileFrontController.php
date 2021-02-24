<?php

namespace DaydreamLab\Media\Controllers\File\Front;

use DaydreamLab\JJAJ\Controllers\BaseController;
use DaydreamLab\Media\Requests\File\Front\FileFrontCheckoutPost;
use DaydreamLab\Media\Requests\File\Front\FileFrontOrderingPost;
use DaydreamLab\Media\Requests\File\Front\FileFrontRemovePost;
use DaydreamLab\Media\Requests\File\Front\FileFrontSearchPost;
use DaydreamLab\Media\Requests\File\Front\FileFrontStatePost;
use DaydreamLab\Media\Requests\File\Front\FileFrontStorePost;
use DaydreamLab\Media\Services\File\Front\FileFrontService;

class FileFrontController extends BaseController
{
    protected $modelName = 'File';

    protected $modelType = 'Front';

    public function __construct(FileFrontService $service)
    {
        parent::__construct($service);
        $this->service = $service;
    }


    public function checkout(FileFrontCheckoutPost $request)
    {
        $this->service->checkout($request->validated());

        return $this->response($this->service->status, $this->service->response);
    }


    public function getItem($id)
    {
        $this->service->getItem($id);

        return $this->response($this->service->status, $this->service->response);
    }


    public function ordering(FileFrontOrderingPost $request)
    {
        $this->service->ordering($request->validated());

        return $this->response($this->service->status, $this->service->response);
    }


    public function remove(FileFrontRemovePost $request)
    {
        $this->service->remove($request->validated());

        return $this->response($this->service->status, $this->service->response);
    }


    public function state(FileFrontStatePost $request)
    {
        $this->service->state($request->validated());

        return $this->response($this->service->status, $this->service->response);
    }


    public function store(FileFrontStorePost $request)
    {
        $this->service->store($request->validated());

        return $this->response($this->service->status, $this->service->response);
    }


    public function search(FileFrontSearchPost $request)
    {
        $this->service->search($request->validated());

        return $this->response($this->service->status, $this->service->response);
    }
}
