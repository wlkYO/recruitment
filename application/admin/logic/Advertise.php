<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/12/16
 * Time: 16:43
 */

namespace app\admin\logic;


class Advertise
{
    public function getAdverurl(){
        $position = new \app\admin\model\Advertise();
        $ret = $position->getAdverurl();
        if ($ret){
            return retmsg(0,$ret);
        }else{
            return retmsg(0);
        }
    }
}