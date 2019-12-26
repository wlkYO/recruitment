<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/12/23
 * Time: 15:55
 */

namespace app\admin\model;


use think\Db;

class WebUser
{
    public function addcompany($data){
        $ret = Db::table('recruit_company')->insertGetId($data);
        return $ret;
    }

    public function adduser($data,$where){
        $ret = Db::table('recruit_user')->where($where)->update($data);
        return $ret;
    }

    public function isexit($where){
        $ret = Db::table('recruit_company')->where($where)->find();
        return $ret;
    }

    public function releasePosition($data,$userinfo){
        $company_id = Db::table('recruit_user')->where('email',$userinfo['email'])->where('state',1)->find();
        $data['company_id'] =$company_id['company_id'];
        $data['create_user'] = $company_id['nickname'];
        $data['create_time'] = date('Y-m-d H:i:s',time());
        $ret = Db::table('recruit_position')->insert($data);
        return $ret;
    }

    public function getPosition($where,$page,$pagesize){
        $ret = Db::table('recruit_position')->where($where)->page($page,$pagesize)->select();
        return $ret;
    }
}