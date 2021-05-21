<?php

namespace DaydreamLab\Media\Controllers\File\Front;

use DaydreamLab\JJAJ\Controllers\BaseController;
use DaydreamLab\JJAJ\Helpers\Helper;
use DaydreamLab\Media\Services\File\Front\FileFrontService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FileFrontController extends BaseController
{
    protected $modelName = 'File';

    protected $modelType = 'Front';

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
            header("Content-type: {$item->contentType}");
            header("Content-Disposition: attachment; filename={$item->blobName}");
            fpassthru($data->getContentStream());
        }
    }
}
