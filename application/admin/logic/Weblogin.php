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
        $where["userid"] = $data["userid"];
        $where["password"] = md5($data["password"]);
        $where['state'] = 1;
        $login = new WebloginModel();
        $ret = $login->login($where);
//        如果账号和密码正确则生成token
        if($ret){
            $settoken["userid"] = $ret["userid"];
            $settoken["roleid"] = $ret["role"];
            $token = createToken($where);
            updatetoken($token["token"],$settoken['userid'],$token);
            $res = array("token"=>$token["token"],"role"=>$ret["role"],"userid"=>$ret["userid"]);
            return retmsg(0,$res,"操作成功");
        }else{
            return array("resultcode" => -1, "resultmsg" => "您做输入的账号或密码错误！", "data" => null);
        }
    }

    public function register($postdata){
        $data['userid'] = $postdata['userid'];
        $data['password'] = md5($postdata['password']);
        $data['email'] = $postdata['email'];
        $data['create_time'] = date('Y-m-d H:i:s',time());
        $login = new WebloginModel();
        $ret = $login->register($data);
        if ($ret){
            return retmsg(0);
        }else{
            return retmsg(-1);
        }
    }
}