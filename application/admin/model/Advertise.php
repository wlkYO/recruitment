<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/12/16
 * Time: 16:43
 */

namespace app\admin\model;


use think\Db;

class Advertise
{
    public function getAdverurl(){
        $ret = Db::table('recruit_advertise')->field('id,url')->select();
        return $ret;
    }
}