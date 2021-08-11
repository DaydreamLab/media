<?php

namespace DaydreamLab\Media\Controllers\File\Front;

use DaydreamLab\JJAJ\Controllers\BaseController;
use DaydreamLab\Media\Requests\File\Front\FileFrontDownloadRequest;
use DaydreamLab\Media\Services\File\Front\FileFrontService;
use Illuminate\Support\Facades\Auth;
use Throwable;

class FileFrontController extends BaseController
{
    protected $package = 'Media';

    protected $modelName = 'File';

    public function __construct(FileFrontService $service)
    {
        parent::__construct($service);
        $this->service = $service;
    }


    public function download(FileFrontDownloadRequest $request)
    {
        $user = Auth::guard('api')->user();
        try {
            $data = $this->service->download(collect([
                'uuid' => $request->route('uuid'),
                'user'  => $user
            ]));
        } catch (Throwable $t) {
            $this->handleException($t);
            return $this->response($this->service->status, null);
        }


        if ($this->service->getProvider() == 'azure') {
            $item = $this->service->response;
            $filename = urlencode($item->name);
            header("Content-Type: {$item->contentType}");
            header("Content-Length: {$data->getProperties()->getContentLength()}");
            header("Content-Disposition:attachment; filename={$filename}");
            fpassthru($data->getContentStream());
        } elseif ($this->service->getProvider() == 'aws') {

        } else {

        }
    }
}
