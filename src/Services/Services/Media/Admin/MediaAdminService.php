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
            $result_media   = $this->media_storage->makeDirectory($path, intval( '0755', 8 ));
            $result_thumb   = $this->thumb_storage->makeDirectory($path, intval( '0755', 8 ));
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


    public function makeTreeDirectories($all)
    {
        $data = [['name'=> '/', 'path'=> '/', 'children' => []]];
        foreach ($all as $directory)
        {
            $data = self::buildTree($data, $directory, '');
        }

        return $data;
    }

    public function buildTree($tree, $node, $delete)
    {
        $copy = [];
        $copy['name'] = $node['name'];
        $copy['path'] = $node['path'];
        $copy['children'] = $node['children'];
        $node = $copy;

        foreach ($tree as $index => $parent)
        {
            $temp_parent_path   = preg_replace('/'.preg_quote($delete, '/'). '/', '', $parent['path'], 1);
            $temp_node_path     = preg_replace('/'.preg_quote($delete, '/'). '/', '', $node['path'],1);
            $temp_parent        = explode('/', $temp_parent_path);
            $temp_node          = explode('/', $temp_node_path);

            if($temp_parent[0] == $temp_node[0])
            {
                $delete = $delete . $parent['name'] .'/';
                $tree[$index]['children'] = self::buildTree($parent['children'], $node, $delete);
                return $tree;
            }
        }
        $tree[] = $node;

        return $tree;
    }



    public function getAllFolders()
    {
        $all    = $this->media_storage->allDirectories();
        $all    = MediaHelper::filterDirectories($all);
        $all    = MediaHelper::appendMeta($all, 'folder', '/', $this->media_storage);
        $data   = $this->makeTreeDirectories($all);

        $this->status =  Str::upper(Str::snake($this->type.'GetAllFoldersSuccess'));;
        $this->response = $data;

        return $data;
    }


    public function getFolders(Collection $input)
    {
        $directories = $this->media_storage->directories($input->dir);
        $directories = MediaHelper::filterDirectories($directories);

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
        foreach ($input->paths as $path)
        {
            $path = substr($path, 1);
            if (is_dir($this->media_path.$path))
            {
                $delete_media = $this->media_storage->deleteDirectory($path);
                $delete_thumb = $this->thumb_storage->deleteDirectory($path);
            }
            else
            {
                $temp = explode('/', $path);
                if ( MediaHelper::isImage(end($temp)))
                {
                    $delete_thumb = $this->thumb_storage->delete($path);
                }
                else
                {
                    $delete_thumb = true;
                }

                $delete_media = $this->media_storage->delete($path);
            }
        }

        if ($delete_thumb && $delete_media)
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


    public function rename(Collection $input)
    {
        if($this->exist($input))
        {
            if ($input->type == 'folder')
            {
                $old = $input->dir . '/' . $input->name;
                $new = $input->dir . '/' . $input->rename;
            }
            else
            {
                $old = $input->dir . $input->name;
                $new = $input->dir . $input->rename;
            }

            if ($this->moveStorage($old, $new))
            {
                $this->status = Str::upper(Str::snake($this->type.'RenameSuccess'));
                $this->response = null;
                return true;
            }
            else
            {
                $this->status = Str::upper(Str::snake($this->type.'RenameFail'));
                $this->response = null;
                return false;
            }
        }
        else
        {
            $this->status = Str::upper(Str::snake('FileNotFound'));
            $this->response = null;
            return false;
        }
    }


    public function upload(Collection $input)
    {
        $complete = true;

        foreach ($input->files as $file)
        {
            if (!$file->getError())
            {
                $extension      = $file->extension();
                $full_name      = $file->getClientOriginalName(); // a.jpg

                $dir            = MediaHelper::getDirPath($input->dir);
                $name           = MediaHelper::getFileName($full_name);
                $file_type      = MediaHelper::getFileExtension($full_name);
                $path           = $dir . $name . '.' . $file_type;

                $counter = 0;
                $final_name = $name;
                while ($this->media_storage->exists($path))
                {
                    $final_name = $name . '(' . ++$counter . ')';
                    $path       = $dir . $final_name . '.' . $file_type;
                }

                $thumb_path     = MediaHelper::getDiskPath($this->thumb_storage_type).$path;

                if (in_array($extension, config('media.extension.image')))
                {
                    $result = Image::make($file)->fit(200)->save($thumb_path);
                }

                if (!$file->storeAs($input->dir, $final_name . '.' . $file_type, 'media-public'))
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
