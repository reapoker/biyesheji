<?php

namespace App\Console\Commands;

use App\Model\ComponentListener;
use Illuminate\Console\Command;

class MakeComponent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:component {name} {--t=} {--d=a component created by command~} {--listenedBy=} {--p=before} {--async=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create a new component in app/Http/Components with cli';

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
        // 创建一个组件，输入组件名，访问方式，组件描述

        $name = $this->argument('name');
        $type = $this->option('t');
        $description = $this->option('d');
        $listenedBy = $this->option('listenedBy'); // 获取被那个组件监听
        $position = $this->option('p'); // 位置
        $async = $this->option('async');
        if ($type == null) {
            throw new \Exception('You must pass a option :  --t=something ');
        }

        if($listenedBy!=null){
            // 如果不为空，向监听表中写入数据
            $cp = new ComponentListener();
            $cp->registerComponentListener($name,$listenedBy,$position,$async);
        }


        $arr = [];
        $arr['name'] = $name;
        $arr['type'] = $type;
        $arr['description'] = $description;
        $arr['model_id'] = 0;
        $arr['php_code'] = '<?php
                function handle($arr){
                return $arr;
                }
        ?>';

        $arr['js_code'] = 'define(function(){
            var handle = function(node,d){

            }
            return {
                handle : handle
            }
        })';


        $c = new \App\Libraries\Component();
        $c->register($arr);
        $c->renderComponentsJson();

        $this->info("Create Successfully!\n");
    }
}