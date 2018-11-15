<?php

namespace DaydreamLab\Media\Helpers;

use Carbon\Carbon;
use DaydreamLab\JJAJ\Helpers\Helper;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class MediaHelper
{
    public static function appendMeta($items, $type, $dir, $storage)
    {
        $result = new Collection();

        foreach ($items as $item)
        {
            $folders = explode('/',$item);
            $temp['name'] = $folders[count($folders)-1];
            $temp['path'] = '/'.$item;
            if ($type == 'folder')
            {
                $temp['type']   = 'Folder';
                $temp['size']   = null;
                $temp['url']    = null;
                $temp['thumb']  = env('APP_URL') . Storage::url('media/thumbs/') . 'icons/folder.png';
            }
            else
            {
                $temp['type']       = $storage->mimeType($item);
                $temp['size']       = round($storage->size($item)/1024) . ' KB';
                $dot_pos            = strrpos($temp['name'],'.');
                $file_type          = Str::substr($temp['name'], $dot_pos + 1);
                $temp['extension']  = $file_type;
                $temp['url']        = $storage->url($item);
                //$temp['thumb']      = env('APP_URL') . Storage::url('media/thumbs') . '/'. substr($dir, 1) . '/' .  $temp['name'];
                $temp['thumb']      = self::getThumbPath($dir, $temp['name'], $file_type, $temp['type'] );
            }
            $temp['modified'] = Carbon::createFromTimestamp($storage->lastModified($item))->toDateTimeString();
            $temp['children'] = [];


            $result->push($temp) ;
        }

        return $result;
    }


    public static function filterDirectories($all)
    {
        $data = [];
        foreach ($all as $directory)
        {
            $temp = explode('/', $directory);
            if($temp[0] != 'thumbs')
            {
                $data[] = $directory;
            }
        }

        return $data;
    }


    public static function getDirPath($path)
    {
        $dir = substr($path, 1);
        $dir = $dir . '/';

        return $dir;
    }


    public static function getFileExtension($name)
    {
        $dot_pos = strrpos($name,'.');

        return Str::substr($name,  $dot_pos + 1);
    }


    public static function getFileName($name)
    {
        $dot_pos = strrpos($name,'.');

        return Str::substr($name, 0, $dot_pos);
    }


    public static function getThumbPath($dir, $name, $extension, $mime)
    {
        $thumb_path = env('APP_URL') . Storage::url('media/thumbs/');

        if (in_array($mime, config('media.mime.image')))
        {
            return $thumb_path . substr($dir, 1) . '/' . $name;
        }
        elseif (in_array($mime, config('media.mime.application')))
        {
            return $thumb_path . 'icons/' . $extension . '-icon.png';
        }
        elseif (in_array($mime, config('media.mime.text')))
        {
            return $thumb_path . 'icons/' . 'file-icon.png';
        }
        else
        {
            return null;
        }
    }

    public static function getDiskPath($disk)
    {
        return Storage::disk($disk)->getAdapter()->getPathPrefix();
    }


    public static function isImage($name)
    {
        return in_array( self::getFileExtension($name), config('media.extension.image')) ? true : false;
    }


    public static function makeTreeDirectories($all)
    {
        $data = [['name'=> '/', 'path'=> '/', 'children' => []]];
        foreach ($all as $directory)
        {
            $data = self::buildTree($data, $directory, '');

        }
        Helper::show($data);
        exit();
    }


    public static function buildTree($tree, $node, $delete)
    {

        Helper::show($tree, $node, $delete);
        foreach ($tree as $index => $parent)
        {

            $temp_item = explode('/', $parent['path']);
            $temp_node = explode('/', $node['path']);

            Helper::show($temp_item, $temp_node);

            if($temp_item[0] == $temp_node[0])
            {
                $delete = $delete.'/'.$temp_item[1];
                //Helper::show($delete);
                $tree[$index]['children'] = self::buildTree($parent['children'], $node, $delete);
                return $tree;
            }
        }
        $tree[0] = $node;


        return $tree;
    }


}