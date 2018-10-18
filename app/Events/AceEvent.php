<?php

namespace App\Events;

use Illuminate\Http\Request;

class AceEvent extends Event
{
    protected $name;
    protected $request;
    /**
     * 事件触发
     *
     * @return void
     */
    public function __construct($name,Request $request)
    {
        // 执行组件
//        $request =  handleComponent($name,$request);
        $this->name = $name;
        $this->request = $request;
    }
}
