<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/12/23
 * Time: 15:55
 */

namespace app\admin\logic;


class WebUser
{
    public function adddetail($data,$userinfo){
        $sexarr = array("1"=>"男","2"=>"女");
        $user['nickname'] = $data['nickname'];
        $user['sex'] = $sexarr[$data['sex']];
        $user['mark'] = $data['mark'];
        $user['position'] = $data['position'];
        $user['header_img'] = $data['header_img'];
        $company['company_name'] = $data['company_name'];
        $company['register_addr'] = $data['register_addr'];
        $company['company_phone'] = $data['company_phone'];
        $company['company_introduce'] = $data['company_introduce'];
        $comwhere['company_name'] = $data['company_name'];
//        是否公司已存在
        $com = new \app\admin\model\WebUser();
        $cunzai = $com->isexit($comwhere);
        if($cunzai){
            return array("resultcode" => -1, "resultmsg" => "该公司已存在，请勿重新添加！", "data" => null);
        }
        $id = $com ->addcompany($company);
        $user['company_id'] = $id;
        $userwhere['email'] = $userinfo['email'];
        $userwhere['state'] = 1;
        $ret = $com ->adduser($user,$userwhere);
        if ($ret){
            return retmsg(0);
        }else{
            return retmsg(-1);
        }
    }

    public function releasePosition($data,$userinfo){
        $position = new \app\admin\model\WebUser();
        $ret = $position->releasePosition($data,$userinfo);
        if ($ret){
            return retmsg(0);
        }else{
            return retmsg(-1);
        }
    }

    public function getPosition($where,$page,$pagesize){
        $position = new \app\admin\model\WebUser();
        $ret = $position->getPosition($where,$page,$pagesize);
        if ($ret){
            return retmsg(0,$ret);
        }else{
            return retmsg(0);
        }
    }
}