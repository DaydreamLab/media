<?php

namespace DaydreamLab\Media\Commands;

use DaydreamLab\JJAJ\Helpers\Helper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install DaydreamLab media component';


    protected $seeder_namespace = 'DaydreamLab\\Media\\Database\\Seeds\\';


    protected $constants = [
        'media'
    ];


    protected $seeders = [
        //'AssetsTableSeeder',
    ];


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        $this->call('jjaj:refresh');
//        $this->call('user:install');
//        foreach ($this->seeders as $seeder) {
//            $this->call('db:seed', [
//                '--class' => $this->seeder_namespace . $seeder
//            ]);
//        }
//
        $this->deleteConstants();

        $this->call('vendor:publish', [
            '--tag' => 'media-configs'
        ]);
    }


    public function deleteConstants()
    {
        $constants_path     = 'config/constants/';
        foreach ($this->constants as $constant) {
            File::delete($constants_path . $constant . '.php');
            File::delete(config_path() . '/'. $constant . '.php');
        }
    }
}
