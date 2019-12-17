<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/12/10
 * Time: 14:41
 */

namespace app\admin\logic;


class User
{
        public function adduser($postdata){
            $postdata['password'] = md5($postdata['password']);
            $email = $postdata['email'];
            $regex= '/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/';
            $result = preg_match($regex,$email);
            if (!$result){
                return array("resultcode" => -1, "resultmsg" => "邮箱格式不正确！", "data" => null);
            }
            $user = new \app\admin\model\User();
            $postdata['create_time'] = date('Y-m-d H:i:s',time());
            $ret = $user->adduser($postdata);
            if ($ret){
                return retmsg(0);
            }else{
                return retmsg(-1);
            }
        }

    public function updateuser($postdata){
        $postdata['password'] = md5($postdata['password']);
        $email = $postdata['email'];
        $regex= '/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/';
        $result = preg_match($regex,$email);
        if (!$result){
            return array("resultcode" => -1, "resultmsg" => "邮箱格式不正确！", "data" => null);
        }
        $user = new \app\admin\model\User();
        $where['id'] = $postdata['id'];
        $ret = $user->updateuser($where,$postdata);
        if ($ret){
            return retmsg(0);
        }else{
            return retmsg(-1);
        }
    }

    public function deluser($postdata){
        $where['id'] = $postdata['id'];
        $data['state'] = 2;
        $user = new \app\admin\model\User();
        $ret = $user->updateuser($where,$data);
        if ($ret){
            return retmsg(0);
        }else{
            return retmsg(-1);
        }
    }

    public function getuser($role,$username,$page,$pagesize){
        $where = array();
        if (!empty($role)){
            $where['a.role'] = $role;
        }
        if (!empty($username)){
            $where['a.username'] = array('like',"%".$username."%");
        }
        $where['a.state'] = 1;
        $user = new \app\admin\model\User();
        $ret = $user->getuser($where,$page,$pagesize);
        $header = array(
            array("headerName"=>"用户账号","field"=>"userid"),
            array("headerName"=>"用户名字","field"=>"username"),
            array("headerName"=>"用户邮箱","field"=>"email"),
            array("headerName"=>"用户角色","field"=>"rolename"),
        );
        if ($ret){
            $ret['header'] = $header;
            return retmsg(0,$ret);
        }else{
            return retmsg(0);
        }
    }
}