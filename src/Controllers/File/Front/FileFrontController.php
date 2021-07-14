<?php

namespace DaydreamLab\Media\Controllers\File\Front;

use DaydreamLab\JJAJ\Controllers\BaseController;
use DaydreamLab\JJAJ\Helpers\Helper;
use DaydreamLab\Media\Services\File\Front\FileFrontService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FileFrontController extends BaseController
{
    protected $package = 'Media';

    protected $modelName = 'File';

    public function __construct(FileFrontService $service)
    {
        parent::__construct($service);
        $this->service = $service;
    }


    public function download(Request $request)
    {
        $user = Auth::guard('api')->user();
        $data = $this->service->download(collect([
            'uuid' => $request->route('uuid'),
            'user'  => $user
        ]));

        if ($this->service->getProvider() == 'azure') {
            $item = $this->service->response;
            $filename = urlencode($item->blobName);
            //header("Response-Type: arraybuffer");
            //header("Accept-Charset: utf-8");
            header("Content-Type: {$item->contentType}");
            header("Content-Length: {$data->getProperties()->getContentLength()}");
            header("Content-Disposition: attachment; filename={$filename}");
            fpassthru($data->getContentStream());
        }
    }
}
