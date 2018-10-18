<?php

namespace App\Console\Commands;

use App\Libraries\Component;
use App\Model\ComponentListener;
use Illuminate\Console\Command;

class RenderComponents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'component:render';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'render all of the components';

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

       $a = new Component();
       $a->renderComponentsJson();
       $this->info("Rendered Successfully!\n");

    }
}