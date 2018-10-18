<?php
function handle($arr)
{
//    $arr['module_id'=>?]
   $module = \App\Model\Module::find($arr['module_id']);
   return iterateClassify(DB::table($module->dir)->get()->toArray());
}

// 返回多维数组表示的分类列表
function iterateClassify($arr){

    $arr = all_to_array($arr);
    $a = [];

    foreach ($arr as $k=>$v){
        $arr[$k]['real_name'] = $v['name'];
    }

    foreach ($arr as $k => $v){
        if($v['pid']==0||$v['pid']==null){
            $a[] = $v; // 把这个数据添加到数组里
        }else{
            $a = setM($a,$v); // 迭代a，寻找id和v的module_id相同的值，并挂载到它的sub上，并且返回$a
        }
    }
    $m = new \App\Model\Module();
    $a = $m->listModule($a);
    return $a; // 返回迭代好的数组
}
function setM($arr,$value){
    foreach ($arr as $k => $v){

        if($v['id']==$value['pid']){
            $arr[$k]['sub'][] = $value;
        }else{
            if(array_key_exists('sub',$v)){
                setM($v['sub'],$value);
            }
        }
    }
    return $arr;
}

?>