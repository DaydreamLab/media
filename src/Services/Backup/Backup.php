<?php

namespace DaydreamLab\Media\Services\Backup;

use DaydreamLab\Media\Services\File\Admin\FileAdminService;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\UploadedFile;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\File\FileRestProxy;

class Backup
{
    public static function backup($filePath, $type)
    {
        $fileName = basename($filePath);
        $arr = explode('_', $fileName);
        if ($type == 'sql') {
            $dir = "backup/{$arr[0]}/sql/{$arr[1]}_{$arr[2]}_{$arr[3]}_{$arr[4]}_{$arr[5]}_{$arr[6]}";
        } else {
            $dir = "backup/{$arr[0]}/site/{$arr[1]}_{$arr[2]}_{$arr[3]}_{$arr[4]}_{$arr[5]}_{$arr[6]}";
        }


        $input = collect([
            'createFile' => 0,
            'files' => [
                new UploadedFile($filePath,  $fileName)
            ],
            'isBackUp' => true,
            'dir' => $dir,
        ]);

        $fileAdminService = app(FileAdminService::class);
        $result = $fileAdminService->upload($input);
    }
}

require __DIR__.'/../../../../../autoload.php';
$app = require __DIR__. '/../../../../../../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();
Backup::backup($argv[1], $argv[2]);
