<?php
/* doc
 * @request integer(module_id) 指定分类模块的id
 * @request string(format) 指定返回数据的格式
 * @response array()    返回的数据类型以及例子
 * */
function handle($arr)
{
    // 指定分类模块的名字
    // 返回数据的格式，是一个列表还是根据pid生成的多维数组
    // 返回list

    // 这个组件应该生成一个有序的一维数组，以pid为外键，以|- 代表子分类
    $res = handleComponent('class_list',$arr);
    $r = [];
    foreach ($res as $v){
        $r[] = [
            'value'=>$v['name'],
            'key'=>$v['real_name']
        ];
    }
    return $r;

}


?>