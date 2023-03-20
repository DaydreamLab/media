<?php

namespace DaydreamLab\Media\Services\Media\Admin;

use DaydreamLab\JJAJ\Helpers\Helper;
use DaydreamLab\JJAJ\Helpers\InputHelper;
use DaydreamLab\Media\Helpers\MediaHelper;
use DaydreamLab\Media\Repositories\Media\Admin\MediaAdminRepository;
use DaydreamLab\Media\Services\Media\MediaService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;

class MediaAdminService extends MediaService
{
    protected $type = 'MediaAdmin';

    protected $modelType = 'Admin';

    protected $order = 'asc';

    protected $order_by = 'name';

    public function __construct(MediaAdminRepository $repo)
    {
        parent::__construct($repo);
    }

    public function createFolder(Collection $input)
    {
        $directories = $this->userMerchantID.$input->get('dir');
        $folder_name = str_replace(' ', '', $input->get('name'));
        $path = $directories . '/' . $folder_name;

        if ( $this->media_storage->exists($path) || $this->thumb_storage->exists($path) )
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
                $this->status = 'CreateFolderSuccess';
                $this->response = null;
            }
            else
            {
                $this->status = 'CreateFolderFail';
                $this->response = null;
            }
            return true;
        }
    }


    public function makeTreeDirectories($all)
    {
        $data = [['name'=> '/', 'path'=> '/', 'children' => []]];
        $format_data = [['name'=> '/', 'path'=> '/', 'children' => []]];

        foreach ($all as $directory)
        {
            $data = self::buildTree($data, $directory, '');
        }

        unset($data[0]);
        foreach( $data as $item ){
            $format_data[0]['children'][] = $item;
        }
        return $format_data;
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

            if($temp_parent[1] == $temp_node[1])
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
        $dir = '/'.$this->userMerchantID;
        $all = $this->media_storage->allDirectories($this->userMerchantID);
        $all = MediaHelper::filterDirectories($all);
        $all = MediaHelper::appendMeta($all, 'folder', $dir, $this->media_storage);

        $data = $this->makeTreeDirectories($all);

        $this->status = 'GetAllFoldersSuccess';
        $this->response = $data;

        return $data;
    }


    public function getFolders(Collection $input)
    {
        $directories = $this->media_storage->directories($input->get('dir'));
        $directories = MediaHelper::filterDirectories($directories);

        $data = MediaHelper::appendMeta($directories, 'folder', $input->get('dir'), $this->media_storage);

        $order_by = InputHelper::null($input, 'order_by')   ? $this->order_by   : $input->get('order_by');

        $order    = InputHelper::null($input, 'order')      ? $this->order      : $input->get('order');

        $data = $order == 'asc' ?  $data->sortBy($order_by) : $data->sortByDesc($order_by);

        return $data;
    }


    public function getFiles(Collection $input)
    {
        $directories = $this->userMerchantID.$input->get('dir');
        $files = $this->media_storage->files($directories);

        $data = MediaHelper::appendMeta($files, 'files', $directories, $this->media_storage);

        $order_by = InputHelper::null($input, 'order_by')   ? $this->order_by   : $input->get('order_by');
        $order    = InputHelper::null($input, 'order')      ? $this->order      : $input->get('order');

        $data = $order == 'asc' ?  $data->sortBy($order_by) : $data->sortByDesc($order_by);

        return $data;
    }


    public function getFolderItems(Collection $input)
    {
        $folders = $this->getFolders($input);
        $files   = $this->getFiles($input);
        $all     = $folders->merge($files);

        $this->status = 'GetFolderItemsSuccess';
        $this->response = $all;

        return $all;
    }


    public function move(Collection $input)
    {
        $directories = $this->userMerchantID.$input->get('dir');
        $target = $this->userMerchantID.$input->get('target');
        $name = $input->get('name');

        $result = $this->media_storage->move($directories . '/' . $name, $target . '/' . $name);

        if ( MediaHelper::isImage($name) )
        {
            $thumb_result = $this->thumb_storage->move($directories . '/' . $name, $target . '/' . $name);
        }
        else
        {
            $thumb_result = true;
        }

        if ($result && $thumb_result)
        {
            $this->status   = 'MoveSuccess';
            $this->response = null;
            return true;
        }
        else
        {
            $this->status   = 'MoveFail';
            $this->response = null;
            return false;
        }
    }


    public function remove(Collection $input, $diff = false)
    {
        foreach ($input->get('paths') as $path)
        {
            if( $this->userMerchantID != null ){
                $comebinePath = $this->userMerchantID.'/'.$path;
            } else {
                $comebinePath = substr($path, 1);
            }

            if (is_dir($this->media_path.$path))
            {
                try{
                    $delete_media = $this->media_storage->deleteDirectory($comebinePath);
                    $delete_thumb = $this->thumb_storage->deleteDirectory($comebinePath);
                }catch (\Exception $e) {
                    Helper::show($e->getMessage());
                }

            }
            else
            {
                $temp = explode('/', $path);
                if ( MediaHelper::isImage(end($temp)))
                {
                    $delete_thumb = $this->thumb_storage->delete($comebinePath);
                }
                else
                {
                    $delete_thumb = true;
                }

                $delete_media = $this->media_storage->delete($comebinePath);
            }
        }

        if ($delete_thumb && $delete_media)
        {
            $this->status   = 'DeleteSuccess';
            $this->response = null;
        }
        else
        {
            $this->status   = 'DeleteFail';
            $this->response = null;
        }
    }


    public function rename(Collection $input)
    {
        $directories = $this->userMerchantID.$input->get('dir');
        if ($input->get('type') == 'folder')
        {
            $old = $directories;
            $newPath = explode('/', $directories);
            unset($newPath[count($newPath) - 1]);
            $new = '';
            foreach ( $newPath as $path ){
                $new.= $path;
            }
            $new = $new . '/' . $input->get('rename');
        }
        else
        {
            if($this->exist($input))
            {
                $old = $directories . '/' . $input->get('name');
                $new = $directories . '/' . $input->get('rename');
            }else
            {
                $this->status = 'FileNotFound';
                $this->response = null;
                return false;
            }
        }

        if ($this->moveStorage($old, $new))
        {
            $this->status = 'RenameSuccess';
            $this->response = null;
            return true;
        }
        else
        {
            $this->status = 'RenameFail';
            $this->response = null;
            return false;
        }
    }

    public function upload(Collection $input)
    {
        $directories = $this->userMerchantID
            ? "/{$this->userMerchantID}".$input->get('dir')
            : $input->get('dir');

        $complete = true;
        $link_path = $this->media_link_base . $directories;
        foreach ($input->get('files') as $file)
        {
            if (!$file->getError())
            {
                $extension      = $file->extension();
                $full_name      = $file->getClientOriginalName(); // a.jpg
                $dir            = MediaHelper::getDirPath($directories);
                $name           = str_replace(' ', '', MediaHelper::getFileName($full_name));
                $file_type      = MediaHelper::getFileExtension($full_name);
                if (
                    config('daydreamlab.media.enabledWhiteList')
                    && ! in_array(strtolower($file_type), config('daydreamlab.media.whiteList'))
                ) {
                    continue;
                }

                $counter = 0;
                $final_name =  config('daydreamlab.media.rename_upload')
                    ? Str::random(36)
                    : $name;

                $path = $dir . $final_name . '.' . $file_type;
                while ($this->media_storage->exists($path)) {
                    if ( config('daydreamlab.media.rename_upload')) {
                        $final_name = Str::random(36);
                    } else {
                        $final_name = $name . '_' . ++$counter;
                    }
                    $path       = $dir . $final_name . '.' . $file_type;
                }

                if (!$this->thumb_storage->exists($dir)) {
                    $this->thumb_storage->makeDirectory($dir, intval( '0755', 8 ));
                }

                $thumb_path = MediaHelper::getDiskPath($this->thumb_storage_type).$path;
                if (in_array($extension, config('daydreamlab.media.extension.image'))) {
                    $result = Image::make($file)->fit(200)->save($thumb_path);
                }

                $link_path .= '/'.$final_name . '.' . $file_type;
                if (!$file->storeAs($directories, $final_name . '.' . $file_type, $this->media_storage_type))
                {
                    $complete = false;
                    break;
                }
            }
        }

        if ($complete) {
            $this->status   = 'UploadSuccess';
            $this->response = ['path' => $link_path];
        } else {
            $this->status   = 'UploadFail';
            $this->response = null;
        }

        return true;
    }
}
