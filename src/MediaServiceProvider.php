<?php

namespace DaydreamLab\Media;


use DaydreamLab\JJAJ\Exceptions\BaseExceptionHandler;
use DaydreamLab\JJAJ\Helpers\Helper;
use DaydreamLab\Media\Helpers\MediaHelper;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Debug\ExceptionHandler;

class MediaServiceProvider extends ServiceProvider
{


    protected $commands = [
        'DaydreamLab\Media\Commands\InstallCommand',
    ];
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__. '/constants' => config_path('constants')], 'media-configs');
        $this->publishes([__DIR__. '/Configs/' => config_path()], 'media-configs');


//        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        include __DIR__. '/routes/api.php';

        // set media disks to filesystems disks
        $filesystems = $this->app['config']->get('filesystems', []);
        $media = require config_path('media.php');
        foreach ($media['disks'] as $key => $disk)
        {
            $filesystems['disks'][$key] = $disk;
        }
        $this->app['config']->set('filesystems',$filesystems);

        $media_public_path = MediaHelper::getDiskPath('media-public');
        $this->publishes([__DIR__.'/resources' => $media_public_path], 'media-configs');

        $this->app->bind(
            ExceptionHandler::class,
            BaseExceptionHandler::class
        );
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
    }
}
