<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/12/23
 * Time: 15:47
 */

namespace app\admin\controller;


use app\admin\logic\WebUser;

class WebUserc
{
//    网站用户信息补全
    public function adddetail($token=''){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
//        $userInfo = checktoken($token);
//        if (!$userInfo) {
//            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
//        }
        $postData = json_decode(file_get_contents("php://input"), true);
        $userInfo['email'] = '1551848357@qq.com';
//        $postData = json_decode('{"company_name":"公司名称","register_addr":"公司地址","company_phone":"18888888888","company_introduce":"公司介绍","nickname":"亚亚奶糖","sex":"1","position":"招聘主管","mark":"帅的不明显系列的个性签名"}', true);
        $user = new WebUser();
        $ret = $user->adddetail($postData,$userInfo);
        return $ret;
    }

//    职位发布
    public function releasePosition($token=''){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
//        $userInfo = checktoken($token);
//        if (!$userInfo) {
//            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
//        }
        $postData = json_decode(file_get_contents("php://input"), true);
        $userInfo['email'] = '1551848357@qq.com';
//        $postData = json_decode('{"industry":"职位类别","address":"公司地址","name":"职位名称","experience":"3年","wages":"5000--6000","xueli":"本科","welfare":"福利待遇","position_detail":"职位描述"}', true);
        $user = new WebUser();
        $ret = $user->releasePosition($postData,$userInfo);
        return $ret;
    }

    public function getPosition($token='',$address='',$name='',$industry='',$experience='',$wages='',$xueli='',$create_time='',$page=1,$pagesize=10){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $userInfo = checktoken($token);
        if (!$userInfo) {
            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
        }
        p($userInfo);die();
//        $postData = json_decode(file_get_contents("php://input"), true);
        $userInfo['email'] = '1551848357@qq.com';
//        $postData = json_decode('{"industry":"职位类别","address":"公司地址","name":"职位名称","experience":"3年","wages":"5000--6000","xueli":"本科","welfare":"福利待遇","position_detail":"职位描述","company_datail":"公司介绍"}', true);
        $user = new WebUser();
        $where = [];
        if(!empty($name)){
            $where['name'] = array('like',"%$name%");
        }
        if(!empty($industry)){
            $where['industry'] = $industry;
        }
        if(!empty($address)){
            $where['address'] = array('like',"%$address%");
        }
        if(!empty($experience)){
            $where['experience'] = $experience;
        }
        if(!empty($wages)){
            $where['wages'] = $wages;
        }
        if(!empty($xueli)){
            $where['xueli'] = $xueli;
        }
        if(!empty($create_time)){
            $where['create_time'] = array('like',"%create_time%");
        }
        $ret = $user->getPosition($where,$page,$pagesize);
        return $ret;
    }
}