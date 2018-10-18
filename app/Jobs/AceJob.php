<?php

namespace App\Jobs;

class AceJob extends Job
{
    protected $name; // 组件名
    protected $request; // 要处理的数据
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($name,$request)
    {
        $this->name = $name;
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        handleComponent($this->name,$this->request); // 运行组件
    }
}
