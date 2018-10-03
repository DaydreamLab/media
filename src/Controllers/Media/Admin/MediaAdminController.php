<?php

namespace DaydreamLab\Media\Controllers\Media\Admin;

use DaydreamLab\JJAJ\Controllers\BaseController;
use DaydreamLab\JJAJ\Helpers\ResponseHelper;
use DaydreamLab\Media\Requests\Media\MediaUploadPost;
use DaydreamLab\Media\Services\Media\Admin\MediaAdminService;


class MediaAdminController extends BaseController
{
    public function __construct(MediaAdminService $service)
    {
        parent::__construct($service);
    }


    public function upload(MediaUploadPost $request)
    {
        $this->service->upload($request->rulesInput());

        return ResponseHelper::response($this->service->status, $this->service->response);
    }
}
