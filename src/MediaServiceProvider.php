<?php

namespace DaydreamLab\Media;

use DaydreamLab\User\Middlewares\Admin;
use DaydreamLab\User\Middlewares\Expired;
use Illuminate\Contracts\Debug\ExceptionHandler;
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
        $this->publishes([__DIR__. '/constants' => config_path('constants')], 'user-configs');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        include __DIR__. '/routes/api.php';
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //$this->app['router']->aliasMiddleware('admin', Admin::class);
        //$this->app['router']->aliasMiddleware('expired', Expired::class);

        $this->commands($this->commands);
    }
}
