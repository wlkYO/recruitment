<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/12/16
 * Time: 16:42
 */

namespace app\admin\controller;


use app\admin\logic\Advertise;

class Advertisec
{
    /**
     * 查询广告图片
     * @param string $token
     * @return mixed
     */

    public function getAdverurl($token=''){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
//        $userInfo = checktoken($token);
//        if (!$userInfo) {
//            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
//        }
        $user = new Advertise();
        $ret = $user->getAdverurl();
        return $ret;
    }
}