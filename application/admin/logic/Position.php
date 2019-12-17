<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/12/10
 * Time: 16:26
 */

namespace app\admin\logic;


class Position
{
    public function addposition($postdata){

    }

    public function updateposition($postdata){

    }

    public function getjobType(){
        $position = new \app\admin\model\Position();
        $ret = $position->getjobType();
        if ($ret){
            return retmsg(0,$ret);
        }else{
            return retmsg(0);
        }
    }
}