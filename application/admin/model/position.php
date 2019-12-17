<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/12/10
 * Time: 16:26
 */

namespace app\admin\model;


use think\Db;

class Position
{
    public function getjobType(){
        $ret =Db::table('recruit_position_type')->where('pid',0)->field('id,typename')->select();
       foreach ($ret as $k=>&$v){
           $v['chldren'] = Db::table('recruit_position_type')->where('pid',$v['id'])->field('id,typename')->select();
       }
       return $ret;
    }
}