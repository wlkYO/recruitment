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

    public function getPosition($where,$page,$pagesize,$timetype){
        $ret =array();$count = 0;
        if($timetype=='timeUp'){
            $ret = Db::table('recruit_position')->alias('a')
                ->join('recruit_company b','a.company_id=b.id','left')
                ->join('recruit_user c','c.company_id=a.company_id','left')
                ->where($where)->order('a.create_time ASC')
                ->field('a.*,b.company_name,c.header_img,c.position,c.nickname,c.sex')
                ->page($page,$pagesize)
                ->select();
            $count = Db::table('recruit_position')->alias('a')
                ->join('recruit_company b','a.company_id=b.id','left')
                ->join('recruit_user c','c.company_id=a.company_id','left')
                ->where($where)->order('a.create_time ASC')
                ->count();
        }
        elseif($timetype=='timeDown'){
            $ret = Db::table('recruit_position')->alias('a')
                ->join('recruit_company b','a.company_id=b.id','left')
                ->join('recruit_user c','c.company_id=a.company_id','left')
                ->where($where)->order('a.create_time DESC')
                ->field('a.*,b.company_name,c.header_img,c.position,c.nickname,c.sex')
                ->page($page,$pagesize)
                ->select();
            $count = Db::table('recruit_position')->alias('a')
                ->join('recruit_company b','a.company_id=b.id','left')
                ->join('recruit_user c','c.company_id=a.company_id','left')
                ->where($where)->order('a.create_time DESC')
                ->count();
        }
        return array("list"=>$ret,"count"=>$count);
    }

    public function collection($data){
        $ret = Db::table('recruit_collection')->insert($data);
        return $ret;
    }

    public function yishoucang($where){
        $ret = Db::table('recruit_collection')->where($where)->find();
        return $ret;
    }

    public function delcollection($where){
        $ret = Db::table('recruit_collection')->where($where)->delete();
        return $ret;
    }

    public function personalCenter($email){
        $ret = Db::table('recruit_user')->alias('a')->join('recruit_company b','a.company_id=b.id','left')
            ->where('a.email',$email)
            ->field('a.username,a.email,a.nickname,a.mark,a.header_img,a.position,a.sex,b.company_name,b.register_addr,b.company_phone,b.company_introduce')->select();
        return $ret;
    }
    public function personalPosition($email){
        $ret = Db::table('recruit_position')->alias('a')->join('recruit_user b','a.company_id=b.company_id','left')
            ->join('recruit_company c','a.company_id=c.id','left')
            ->where('b.email',$email)
            ->field('b.header_img,b.position,b.nickname,b.sex,c.company_name,a.*')->select();
        return $ret;
    }

    public function positionBigtype($id){
        if(!empty($id)){
            $ret = Db::query("select b.header_img,b.position,b.nickname,b.sex,c.company_name,a.* from recruit_position a LEFT JOIN recruit_user b on a.company_id=b.company_id 
                              LEFT JOIN recruit_company c on a.company_id=c.id where a.industry in (select typename from recruit_position_type where pid=$id)");
        }
        else{
            $ret = Db::query("select b.header_img,b.position,b.nickname,b.sex,c.company_name,a.* from recruit_position a LEFT JOIN recruit_user b on a.company_id=b.company_id LEFT JOIN recruit_company c on a.company_id=c.id");
        }
        return $ret;
    }

    public function editdetail($where,$company,$user){
        $ret = Db::table('recruit_user')->where($where)->update($user);
        if(!empty($company)){
            $ret = Db::table('recruit_company')->where($where)->update($company);
        }
        return  $ret;
    }

    public function positionDetail($id){
        $ret = Db::query("select b.header_img,b.position,b.nickname,b.sex,c.company_name,c.company_introduce,a.* from recruit_position a 
                          LEFT JOIN recruit_user b on a.company_id=b.company_id LEFT JOIN recruit_company c on a.company_id=c.id where a.id=$id");
        return $ret;
    }

    public function releaseLiuyan($data){
        $ret = Db::table('recruit_liuyan')->insert($data);
        return $ret;
    }

    public function getLiuyan($email){
        $ret = Db::query("SELECT a.*,b.company_name,c.name,u.nickname,u.header_img,u2.nickname nickname_reply,u2.header_img header_img_reply 
                          FROM `recruit_liuyan` a,recruit_company b, recruit_position c,recruit_user u,recruit_user u2 where a.company_id = b.id 
                          and a.position_id = c.id and a.email=u.email and a.replay_email=u2.email and a.email='$email'");
        return $ret;
    }

    public function replyLiuyan($data,$where){
        $ret = Db::table('recruit_liuyan')->where($where)->update($data);
        return $ret;
    }

    public function addLog($data){
        $ret = Db::table('recruit_log')->insert($data);
        return $ret;
    }

    public function uploadResume($data){
        $ret = Db::table('recruit_resume')->insert($data);
        return $ret;
    }
}