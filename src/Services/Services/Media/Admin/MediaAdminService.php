<?php

namespace DaydreamLab\Media\Services\Media\Admin;

use DaydreamLab\JJAJ\Helpers\Helper;
use DaydreamLab\JJAJ\Helpers\InputHelper;
use DaydreamLab\Media\Helpers\MediaHelper;
use DaydreamLab\Media\Repositories\Media\Admin\MediaAdminRepository;
use DaydreamLab\Media\Services\Media\MediaService;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;


class MediaAdminService extends MediaService
{
    protected $type = 'MediaAdmin';

    protected $order = 'asc';

    protected $order_by = 'name';


    public function __construct(MediaAdminRepository $repo)
    {
        parent::__construct($repo);
    }


    public function createFolder(Collection $input)
    {
        $path = $input->dir . '/' . $input->name;
        if ($this->media_storage->exists($input->dir . '/' . $input->name) ||
            $this->thumb_storage->exists($input->dir . '/' . $input->name) )
        {
            $this->status =  Str::upper(Str::snake($this->type.'FolderAlreadyExist'));;
            $this->response = null;
            return false;
        }
        else
        {
            $result_media   = $this->media_storage->makeDirectory(Str::lower($path));
            $result_thumb   = $this->thumb_storage->makeDirectory(Str::lower($path));
            if ($result_media && $result_thumb)
            {
                $this->status =  Str::upper(Str::snake($this->type.'CreateFolderSuccess'));;
                $this->response = null;
            }
            else
            {
                $this->status =  Str::upper(Str::snake($this->type.'CreateFolderFail'));;
                $this->response = null;
            }
            return true;
        }
    }


    public function getAllFolders()
    {
        $all = $this->media_storage->allDirectories();

        $data = MediaHelper::appendMeta($all, 'folder', '/', $this->media_storage);

        $this->status =  Str::upper(Str::snake($this->type.'GetAllFoldersSuccess'));;
        $this->response = $data;

        return $data;
    }


    public function getFolders(Collection $input)
    {
        $directories = $this->media_storage->directories($input->dir);

        $data = MediaHelper::appendMeta($directories, 'folder', $input->dir, $this->media_storage);

        $order_by = InputHelper::null($input, 'order_by')   ? $this->order_by   : $input->order_by;

        $order    = InputHelper::null($input, 'order')      ? $this->order      : $input->order;

        $data = $order == 'asc' ?  $data->sortBy($order_by) : $data->sortByDesc($order_by);

        return $data;
    }


    public function getFiles(Collection $input)
    {
        $files = $this->media_storage->files($input->dir);

        $data = MediaHelper::appendMeta($files, 'files', $input->dir, $this->media_storage);

        $order_by = InputHelper::null($input, 'order_by')   ? $this->order_by   : $input->order_by;
        $order    = InputHelper::null($input, 'order')      ? $this->order      : $input->order;

        $data = $order == 'asc' ?  $data->sortBy($order_by) : $data->sortByDesc($order_by);

        return $data;
    }


    public function getFolderItems(Collection $input)
    {
        $folders = $this->getFolders($input);
        $files   = $this->getFiles($input);
        $all     = $folders->merge($files);

        $this->status =  Str::upper(Str::snake($this->type.'GetFolderItemsSuccess'));;
        $this->response = $all;

        return $all;
    }


    public function move(Collection $input)
    {
        $result = $this->media_storage->move($input->dir . $input->name, $input->target . '/'. $input->name);
        if ($result)
        {
            $this->status   = Str::upper(Str::snake($this->type.'MoveSuccess'));
            $this->response = null;
            return true;
        }
        else
        {
            $this->status   = Str::upper(Str::snake($this->type.'MoveFail'));
            $this->response = null;
            return false;
        }
    }


    public function remove(Collection $input)
    {
        if ($input->type == 'Folder')
        {
            $result = $this->media_storage->deleteDirectory($input->path);
        }
        else
        {
            $result = $this->media_storage->delete($input->path);
        }

        if ($result)
        {
            $this->status   = Str::upper(Str::snake($this->type.'DeleteSuccess'));
            $this->response = null;
        }
        else
        {
            $this->status   = Str::upper(Str::snake($this->type.'DeleteFail'));
            $this->response = null;
        }
    }


    public function upload(Collection $input)
    {
        $complete = true;

        foreach ($input->files as $file)
        {
            if (!$file->getError())
            {
                $extension      = $file->guessExtension();
                $full_name      = $file->getClientOriginalName(); // a.jpg
                $actual_name    = $final_name = Str::substr($full_name, 0, strrpos($full_name,'.'));
                $input->dir =  strlen($input->dir) == 1 ? '' :  $input->dir;

                $path           = $input->dir. '/'. $full_name;
                $thumb_path     = MediaHelper::getDiskPath($this->thumb_storage_type);
                $thumb_name     = substr($thumb_path, 0, -1) . $input->dir . '/'.$final_name . '.' . $extension;

                $counter = 0;
                while ($this->media_storage->exists($path))
                {
                    $final_name = $actual_name . '(' . ++$counter . ')';
                    $path = $input->dir. '/'. $final_name  . '.' . $extension;
                }

                $result = Image::make($file)->fit(200)->save($thumb_name);
                if ( $result && !$file->storeAs($input->dir, $final_name . '.' . $extension, 'media-public'))
                {
                    $complete = false;
                    break;
                }
            }
        }

        if ($complete)
        {
            $this->status   =  Str::upper(Str::snake($this->type.'UploadSuccess'));
            $this->response = null;
        }
        else
        {
            $this->status   =  Str::upper(Str::snake($this->type.'UploadFail'));
            $this->response = null;
        }

        return true;
    }
}
