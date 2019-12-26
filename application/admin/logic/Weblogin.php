<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/12/11
 * Time: 10:12
 */

namespace app\admin\logic;
use app\admin\model\Weblogin as WebloginModel;
use PHPMailer\PHPMailer\PHPMailer;

class Weblogin
{
    public function login($data){
        $where["email"] = $data["email"];
        $where["password"] = md5($data["password"]);
        $where['state'] = 1;
        $login = new WebloginModel();
        $ret = $login->login($where);
//        如果账号和密码正确则生成token
        if($ret){
            $settoken["username"] = $ret["username"];
            $settoken["roleid"] = $ret["role"];
            $settoken["email"] = $ret["email"];
            $token = createToken($settoken);
            updatetoken($token["token"],$settoken['email'],$token);
            $res = array("token"=>$token["token"],"role"=>$ret["role"],"username"=>$ret["username"]);
            return retmsg(0,$res,"操作成功");
        }else{
            return array("resultcode" => -1, "resultmsg" => "您所输入的账号或密码错误！", "data" => null);
        }
    }

    public function register($postdata){
        $data['username'] = "用户".$postdata['email'];
        $data['password'] = md5($postdata['password']);
        $data['email'] = $postdata['email'];
        $data['create_time'] = date('Y-m-d H:i:s',time());
        if($postdata['isSon']==1){
            $data['role']=3;
        }elseif($postdata['isSon']==0){
            $data['role']=2;
        }
        $login = new WebloginModel();
        $ret = $login->register($data);
        if ($ret){
            return retmsg(0);
        }else{
            return retmsg(-1);
        }
    }

    public function editpassword($postdata){
        if($postdata['newpassword1']!=$postdata['newpassword2']){
            return array("resultcode" => -1, "resultmsg" => "确认密码和新密码不一致！", "data" => null);
        }
        $data['password'] = md5($postdata['newpassword1']);
        $where['email'] = $postdata['email'];
        $login = new WebloginModel();
        $ret = $login ->editpassword($where,$data);
        if ($ret){
            return retmsg(0);
        }else{
            return retmsg(-1);
        }
    }
}