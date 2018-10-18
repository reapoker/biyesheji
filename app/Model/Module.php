<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'modules';
    protected $exp = 0;
    protected $d = [];
//    protected $c = [];
    public function getModuleList($type = 'list'){
        $arr = self::all()->toArray(); // 把所有模块数据取出
        foreach ($arr as $k => $v){
            $model_id = $v['model_id']; // 获取模型id
            $m = Mould::find($model_id);
            $arr[$k]['mould_name'] = $m->dir;
            // 根据模型id获取模版映射
            $dir = '\App\Http\Moulds\\' . $m->dir . '\\'. $m->dir;
            $module = new $dir();
            $arr[$k]['template_map'] = $module->getModuleTemp();
        }
        // 两种 list是二位数组，层级用|-表示， iteration是多位数组，层级用数组的['sub']表示
        $arr = $this->iterateModule($arr);  // 获取到叠加的数据
        if($type == 'list'){
            return $this->listModule($arr);
        }
        if($type == 'iteration'){
            return $arr;
        }
    }

    // 返回二维数组表示的模块列表
    public function listModule($arr){
         foreach ($arr as $v){
             $this->exp += 1;
             $x = '';
             if($this->exp > 1){
                 $x = '|--';
                 for($i = 1; $i<$this->exp;$i++){
                     $x = '' . $x;
                 }
             }
             $v['name'] = $x . $v['name'];
             array_push($this->d,$v);
             if(array_key_exists('sub',$v) && !empty($v['sub'])){
                 $this->listModule($v['sub']);
                 unset($v['sub']);
             }
             $this->exp -= 1;
         }
        return $this->d;
    }
    // 返回多维数组表示的模块列表
    protected function iterateModule($arr){
        $a = [];
        foreach ($arr as $k => $v){
            if($v['module_id']==0){
                $a[] = $v; // 把这个数据添加到数组里
            }else{
                $a = $this->setM($a,$v); // 迭代a，寻找id和v的module_id相同的值，并挂载到它的sub上，并且返回$a
            }
        }
        return $a; // 返回迭代好的数组
    }

    protected function setM($arr,$value){
        foreach ($arr as $k => $v){
            if($v['id']==$value['module_id']){
                $arr[$k]['sub'][] = $value;
            }else{
                if(array_key_exists('sub',$v)){
                    $this->setM($v['sub'],$value);
                }
            }
        }
        return $arr;
    }

}
