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
                $temp['thumb']  = env('APP_URL') . Storage::url('thumbs') . '/' . config('media.folder_thumb');
            }
            else
            {
                $temp['type']   = $storage->mimeType($item);
                $temp['size']   = round($storage->size($item)/1024) . ' KB';
                $temp['url']    = $storage->url($item);
                $temp['thumb']  = env('APP_URL') . Storage::url('thumbs') . '/' .  $temp['name'];
            }
            $temp['modified'] = Carbon::createFromTimestamp($storage->lastModified($item))->toDateTimeString();

            $result->push($temp) ;
        }

        return $result;
    }

    public static function getDiskPath($disk)
    {
        return Storage::disk($disk)->getAdapter()->getPathPrefix();
    }

}