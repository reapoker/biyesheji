<?php

namespace App\Console\Commands;

use App\Libraries\Component;
use App\Model\ComponentListener;
use Illuminate\Console\Command;

class WatchComponent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'component:watch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '监听组件变化，当组件js有变动时，自动将组件渲染到public目录中';

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
       $components = $a->components;
        echo "正在开启监听... \n";
        // 循环遍历，查到不同后，开始渲染
        try{
           echo "开启成功，正在监听组件变化... \n";
           while (true){
               foreach ($components as $v){
                   $p_path = $a->getAppJsPath($v['name']);
                   $j_path = $a->getPublicJsPath($v['name']);
                   $res = exec('diff -bBq '.$p_path . " " . $j_path );
                   if(strpos($res,'differ')){
                       $this->info( "[". date("Y-m-d H:i:s",time()) ."] \n".$v['name']."发现不同！ 开始同步... \n");
                       $a->renderSingleComponent($v['name']);
                       $this->info("[". date("Y-m-d H:i:s",time()) ."] \n". $v['name']. "同步完成！\n");
                   }
               }
           }
        }catch (\Exception $e){
            throw new \Exception("此命令仅适用于linux系统！" . $e->getMessage());
        }

//       echo "Rendered Successfully!\n";

    }
}