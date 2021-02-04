<?php

return [

    'disks' => [

        'media-public'  => [
            'driver'    => 'local',
            'root'      => storage_path('app/public/media'),
            'url'       => config('app.url').'/storage/media',
            'visibility'=> 'public',
        ],

        'media-public-merchant'  => [
            'driver'    => 'local',
            'root'      => storage_path('app/public/media/merchant'),
            'url'       => config('app.url').'/storage/media/merchant',
            'visibility'=> 'public',
        ],

        'media-thumb'   => [
            'driver'    => 'local',
            'root'      => storage_path('app/public/media/thumbs'),
            'url'       => config('app.url').'/storage/media/thumbs',
            'visibility'=> 'public',
        ],

        'media-thumb-merchant'   => [
            'driver'    => 'local',
            'root'      => storage_path('app/public/media/thumbs/merchant'),
            'url'       => config('app.url').'/storage/media/thumbs/merchant',
            'visibility'=> 'public',
        ],

        'media-private' => [
            'driver'    => 'local',
            'root'      => storage_path('app/private/media'),
            'url'       => config('app.url').'/admin/media',
            'visibility'=> 'private',
        ],
    ],


    'mime'  => [
        'image' => [
            'image/png',
            'image/jpeg'
        ],
        'application'   => [
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'application/pdf'
        ],
        'text'  => [
            'text/plain'
        ]
    ],

    'extension' => [
        'image'         => ['png', 'jpg', 'jpeg'],
        'application'   => ['doc', 'docx', 'csv', 'xls', 'xlsx'],
        'text'          => ['txt', 'json', 'csv']
    ],

    'dddream-merchant-mode' => 0,

    'rename_upload' => 0,

    'upload_limit' => env('MEDIA_UPLOAD_LIMIT', 10240) // kBs
];