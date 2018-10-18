<?php
function handle($arr)
{
    // 配置权限验证组件，更改一些配置项
    config(['auth.providers.users.model'=>\App\Model\Associator::class]);
    // 判断有几个会员模块，给Associator设置表名
    $mould = \App\Model\Mould::where('dir','Associator')->first()->toArray();
    if(empty($mould)) throw new \Exception("未安装会员模型！请安装后再试！");

    $table_name = ''; // 表名
    $module = \App\Model\Module::where('model_id',$mould['id'])->get()->toArray();
    $module = all_to_array($module);
    if(count($module)==1){
        $table_name = $module[0]['dir'];
    }else{
        $table_name = $arr->header('associator'); // 如果有多个用户模块，每个模块必须在header中把对应的用户表传递进来
        if(is_null($table_name)||$table_name=='') throw new \Exception("存在多个用户模块，请在header中指定associator的用户表");
    }
//    $arr['set_associator_table'] = $table_name;

    // 绑定模型表名
    $model = new \App\Model\Associator();
    $model->setTable($table_name);
//    $model->save();
    return $arr;
}

?>