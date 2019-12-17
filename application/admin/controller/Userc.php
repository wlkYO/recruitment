<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/12/10
 * Time: 14:03
 */

namespace app\admin\controller;
use app\admin\logic\User;
class Userc
{
    /**
     * 添加/修改人员
     * @param string $token
     * @return mixed
     */
    public function adduser($token = '')
    {
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
//        $userInfo = checktoken($token);
//        if (!$userInfo) {
//            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
//        }
//        $postData = json_decode(file_get_contents("php://input"), true);
        $postData = json_decode('{"id":1,"userid":"18382274650","username":"帅哥袁1","password":"123456","email":"1562656817@qq.com"}', true);
        $user = new User();
        if (array_key_exists("id", $postData)){
            $ret = $user->updateuser($postData);
        }else{
            $ret = $user->adduser($postData);
        }
        return $ret;
    }

    /**
     * 删除人员，假删除
     * @param string $token
     * @return mixed
     */
    public function deluser($token=''){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
//        $userInfo = checktoken($token);
//        if (!$userInfo) {
//            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
//        }
        //        $postData = json_decode(file_get_contents("php://input"), true);
        $postData = json_decode('{"id":1}', true);
        $user = new User();
        $ret = $user->deluser($postData);
        return $ret;
    }

    /**
     * 查询人员
     * @param string $token
     * @return mixed
     */
    public function getuser($token='',$role='',$username='',$page=1,$pagesize=10){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
//        $userInfo = checktoken($token);
//        if (!$userInfo) {
//            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
//        }
        $user = new User();
        $ret = $user->getuser($role,$username,$page,$pagesize);
        return $ret;
    }

}