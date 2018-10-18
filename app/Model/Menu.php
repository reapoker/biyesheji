<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //需要让该模型指定对应的表
    public $table = 'admin_menus';

    /**
     * @param User $user 当前用户
     * @param int $type 当前要查询的类型（content代表内容管理，site代表网站管理）
     * @return string 返回获得菜单的数组
     */
    public function getMenuList($type = 'content')
    {
        //目前只支持到二级菜单
        $menu = [];
        if($type=='content'){
            // 内容管理
            $db_menus = self::with(['children'])->where('type', 'content')->orWhere('type','content_quick')->orderBy('order_id')->get()->toArray();  //从数据库中取出
        }else{
            // 网站管理
            $db_menus = self::with(['children'])->where('type', 'site_control')->orWhere('type','site_control_quick')->orderBy('order_id')->get()->toArray();  //从数据库中取出
        }

        foreach ($db_menus as $v) {
            if ($v['pid'] == 0) {
                $menu[$v['id']] = $v;
            }
        }

        foreach ($db_menus as $v) {
            if ($v['pid'] != 0) {
                $menu[$v['pid']]['next'][] = $v;
            }
        }
        return $menu;
    }

    public function getSiteControlList(){
        $arr = self::with(['children'])->where('type','site_control')->orderBy('order_id','desc')->get()->toArray();
        foreach ($arr as $k => $v){
            if($v['pid']!=0){
                unset($arr[$k]);
            }
        }
        return $arr;
    }

    public function getSiteControlQuickList(){
         $arr = self::with(['children'])->where('type','site_control_quick')->orderBy('order_id')->get()->toArray();
        foreach ($arr as $k => $v){
            if($v['pid']!=0){
                unset($arr[$k]);
            }
        }
         return $arr;
    }

    public function getContentList(){
        $arr = self::with(['children'])->where('type','content')->orderBy('order_id')->get()->toArray();
        foreach ($arr as $k => $v){
            if($v['pid']!=0){
                unset($arr[$k]);
            }
        }
        return $arr;
    }
    public function getContentQuickList(){
        $arr = self::with(['children'])->where('type','content_quick')->orderBy('order_id')->get()->toArray();
        foreach ($arr as $k => $v){
            if($v['pid']!=0){
                unset($arr[$k]);
            }
        }
        return $arr;
    }
    public function children()
    {
        return $this->hasMany(get_class($this), 'pid', $this->getKeyName());
    }

    // 获取所有顶级菜单
    public function getTopList(){
        return self::where('pid',0)->orderBy('order_id')->get()->toArray(); // 获取所有pid为0的菜单
    }

    public function addMenu($data){
        // 添加新的菜单
        $m = new Menu();
        $m->name=$data['name'];
        $m->name_en=$data['name_en'];
        $m->authority_name=$data['name_en'];
        $m->type =$data['type'];
        $m->belong_site='default';
        $m->icon= 'folder-o';
        $m->pid = $data['pid'];
        $m->save();
        return $data;
    }


    // 更新菜单顺序
    public function menuUpdate($type,$data){
        foreach ($data as $k => $v){  // 把id和orderid的更新
            self::where('id',$v['id'])->update(['order_id'=>$k,'pid'=>0]); // 第一层循环，要把pid设为0
            if(array_key_exists('children',$v)){
                foreach ($v['children'] as $kk => $vv){
                    self::where('id',$vv['id'])->update(['order_id'=>$kk,'pid'=>$v['id']]);
                }
            }

        }
        return true;
    }
}
