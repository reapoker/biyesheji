<?php
function handle($arr)
{
    // 获取自定义数据，select->mould=Classification&module=daifa_fenlei&aa=2&cc=3
    // 先去掉前面的表现形式select，用不到
    // 然后解析模型名称和模块名称还有其他方法
    // 如果指定了组件名称，就调用组件返回组件结果，如果没有就返回指定的模块列表
    $c = explode('->',$arr['custom_option']);
    $options = [];
    if(count($c)==2){
        $option_list = explode('&',$c[1]);
        foreach ($option_list as $v){
            $op = explode('=',$v);
            if(count($op)==2){
                $options[$op[0]] = $op[1];
            }else{
                throw new \Exception("自定义组件数据格式错误！");
            }
        }
    }

   // 已经把数据转换为数组
    if(array_key_exists('component_name',$options)){
        // 如果指定了组件名，就调用组件,比如要返回所有模块列表，就调用module_list组件
        return handleComponent($options['component_name'],$options);
    }
    // 指定了模块，返回该模块下所有文档的列表
    if(array_key_exists('module',$options) && array_key_exists('module_column',$options)){
        $if_table_exist = \Illuminate\Support\Facades\Schema::hasTable($options['module']);
        if($if_table_exist){
//            $options['module_column'] = 'name';
            $res = DB::table($options['module'])->select($options['module_column'])->get();
            $r = [];
            $res = all_to_array($res);
            foreach ($res as $v){
                $r[] = $v[$options['module_column']];
            }
            return $r;
        }
    }

    if(array_key_exists('mould',$options)){

        // 指定了模型，返回该模型下所有模块的列表
        $mould_id = DB::table('models')->where('dir',$options['mould'])->select('id')->first();  // 获取指定模型的id
        $modules = DB::table('modules')->where('model_id',$mould_id->id)->select('name')->get();
        $res = all_to_array($modules);
        $r = [];
        foreach ($res as $v){
            $r[] = $v['name']; // 模块只能返回名字
        }
        return $r;
    }
    // 返回值中必须是一个1维数组，option的value和中间的值相同


}

?>