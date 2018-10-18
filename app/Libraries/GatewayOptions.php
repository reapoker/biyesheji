<?php
/**
 * Created by PhpStorm.
 * User: silsuer
 * Date: 2018/3/19
 * Time: 17:28
 */

namespace App\Libraries;
use GatewayClient\Gateway;
use Illuminate\Auth\Access\Gate;
use Illuminate\Support\Facades\DB;

// 在组件中操作这个类，进行绑定等操作
class GatewayOptions
{
//    public $register = '192.168.2.181:1238';
    public $register = '10.194.60.18:1238';

    public function __construct()
    {
        Gateway::$registerAddress = $this->register;
    }

    public function bindUid($client,$uid){
        return Gateway::bindUid($client,$uid);
    }

    public function SendToUid($uid,$data){
        $res =  Gateway::sendToUid($uid,$data);
        return $res;
    }

    public function isUidOnline($uid){
        $res = Gateway::isUidOnline($uid);
        return $res;
    }

    public function sendToAll($msg){
        return Gateway::sendToAll($msg);
    }

    public function unbindUid($uid){

    }

    public static function saveHistory($data){
        if(!is_string($data)) $data = json_encode($data);
        $n = [
            'time' =>date("Y-m-d H:i:s",time()),
            'details'=>$data
        ];

        DB::table('bs_history')->insert($n);
    }
}