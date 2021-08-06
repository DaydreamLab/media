<?php

namespace DaydreamLab\Media;

use DaydreamLab\Media\Helpers\MediaHelper;
use Illuminate\Support\ServiceProvider;

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
        $this->publishes([__DIR__. '/Configs/' => config_path('daydreamlab')], 'media-configs');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'media');

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        include __DIR__. '/routes/api.php';

        // set media disks to filesystems disks
        $filesystems = $this->app['config']->get('filesystems', []);

        $media = MediaHelper::getMediaConfig();

        foreach ($media['disks'] as $key => $disk)
        {
            $filesystems['disks'][$key] = $disk;
        }
        $this->app['config']->set('filesystems',$filesystems);

        $media_public_path = MediaHelper::getDiskPath('media-public');

        $this->publishes([__DIR__ . '/../resources/' => $media_public_path.'/thumbs'], 'media-configs');
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
