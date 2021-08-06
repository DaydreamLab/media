<?php

namespace DaydreamLab\Media\Controllers\Media\Admin;

use DaydreamLab\JJAJ\Exceptions\ForbiddenException;
use DaydreamLab\JJAJ\Exceptions\InternalServerErrorException;
use DaydreamLab\Media\Controllers\MediaController;
use DaydreamLab\Media\Requests\Media\Admin\MediaAdminCreateFolderPost;
use DaydreamLab\Media\Requests\Media\Admin\MediaAdminGetFoldersPost;
use DaydreamLab\Media\Requests\Media\Admin\MediaAdminDeletePost;
use DaydreamLab\Media\Requests\Media\Admin\MediaAdminGetFolderItemsPost;
use DaydreamLab\Media\Requests\Media\Admin\MediaAdminMovePost;
use DaydreamLab\Media\Requests\Media\Admin\MediaAdminRenamePost;
use DaydreamLab\Media\Requests\Media\Admin\MediaAdminUploadPost;
use DaydreamLab\Media\Resources\Media\Admin\Collections\MediaAdminListResourceCollection;
use DaydreamLab\Media\Services\Media\Admin\MediaAdminService;
use Symfony\Component\Cache\Exception\LogicException;
use Throwable;

class MediaAdminController extends MediaController
{
    protected $modelName = 'Media';

    public function __construct(MediaAdminService $service)
    {
        parent::__construct($service);
        $this->service = $service;
    }


    public function createFolder(MediaAdminCreateFolderPost $request)
    {
        $this->service->setUser($request->user());
        try {
            $this->service->createFolder($request->validated());
        } catch (Throwable $t) {
            $this->handleException($t);
        }

        return $this->response($this->service->status, $this->service->response);
    }


    public function getAllFolders(MediaAdminGetFoldersPost $request)
    {
        $this->service->setUser($request->user());
        try {
            $this->service->getAllFolders();
        } catch (Throwable $t) {
            $this->handleException($t);
        }

        return $this->response($this->service->status, $this->service->response);
    }


    public function getFolderItems(MediaAdminGetFolderItemsPost $request)
    {
        $this->service->setUser($request->user());
        try {
            $this->service->getFolderItems($request->validated());
        } catch (Throwable $t) {
            $this->handleException($t);
        }

        return $this->response($this->service->status, $this->service->response, [], MediaAdminListResourceCollection::class);
    }


    public function move(MediaAdminMovePost $request)
    {
        $this->service->setUser($request->user());
        try {
            $this->service->move($request->validated());
        } catch (Throwable $t) {
            $this->handleException($t);
        }

        return $this->response($this->service->status, $this->service->response);
    }


    public function remove(MediaAdminDeletePost $request)
    {
        $this->service->setUser($request->user());
        try {
            $this->service->remove($request->validated());
        } catch (Throwable $t) {
            $this->service->transParams = [
                'reason'    => $t->getMessage()
            ];
            if ($t instanceof \LogicException) {
                $t = new ForbiddenException('LogicError', null, null, $this->modelName);
            }
            $this->handleException($t);
        }

        return $this->response($this->service->status, $this->service->response, $this->service->transParams);
    }


    public function rename(MediaAdminRenamePost $request)
    {
        $this->service->setUser($request->user());
        try {
            $this->service->rename($request->validated());
        } catch (Throwable $t) {
            $this->handleException($t);
        }

        return $this->response($this->service->status, $this->service->response);
    }


    public function upload(MediaAdminUploadPost $request)
    {
        $this->service->setUser($request->user());
        try {
            $this->service->upload($request->validated());
        } catch (Throwable $t) {
            $this->handleException($t);
        }

        return $this->response($this->service->status, $this->service->response);
    }
}
