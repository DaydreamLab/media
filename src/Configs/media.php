<?php

return [

    'folder_thumb' => 'folder.jpg',

    'disks' => [

        'media-public'  => [
            'driver'    => 'local',
            'root'      => storage_path('app/public/media'),
            'url'       => env('APP_URL').'/storage/media',
            'visibility'=> 'public',
        ],

        'media-thumb'   => [
            'driver'    => 'local',
            'root'      => storage_path('app/public/media/thumbs'),
            'url'       => env('APP_URL').'/storage/media/thumbs',
            'visibility'=> 'public',
        ],

        'media-private' => [
            'driver'    => 'local',
            'root'      => storage_path('app/private/media'),
            'url'       => env('APP_URL').'/admin/media',
            'visibility'=> 'private',
        ],
    ],

];