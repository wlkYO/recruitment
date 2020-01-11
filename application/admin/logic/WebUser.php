<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/12/23
 * Time: 15:55
 */

namespace app\admin\logic;


use think\Db;

class WebUser
{
    public function adddetail($data,$userinfo){
        $sexarr = array("1"=>"男","2"=>"女");
        $com = new \app\admin\model\WebUser();
        $user['nickname'] = $data['nickname'];
        $user['sex'] = $sexarr[$data['sex']];
        $user['mark'] = $data['mark'];
        $user['position'] = $data['position'];
        $user['header_img'] = $data['header_img'];
        $userwhere['email'] = $userinfo['email'];
//        3为求职者，2为招聘者
        if($userinfo['roleid']==3) {
            $user['qiwang_wages'] = $data['qiwang_wages'];
            $user['qiwang_city'] = $data['qiwang_city'];
            $user['xueli'] = $data['xueli'];
            if ($data['method'] == 'add') {
                $com->adduser($user, $userwhere);
            } else {
                $com->editdetail($userwhere, null, $user);
            }
            return retmsg(0);
        }
        if($userinfo['roleid']==2){
            $company['company_name'] = $data['company_name'];
            $company['email'] = $userinfo['email'];
            $company['register_addr'] = $data['register_addr'];
            $company['company_phone'] = $data['company_phone'];
            $company['company_introduce'] = $data['company_introduce'];
            if($data['method']=='add'){
                $comwhere['company_name'] = $data['company_name'];
                $comwhere['email'] = $userinfo['email'];
//        是否公司已存在
                $cunzai = $com->isexit($comwhere);
                if($cunzai){
                    return array("resultcode" => -1, "resultmsg" => "该公司已存在，请勿重新添加！", "data" => null);
                }
                $id = $com ->addcompany($company);
                $user['company_id'] = $id;
                $userwhere['email'] = $userinfo['email'];
                $userwhere['state'] = 1;
                $com ->adduser($user,$userwhere);
            }else{
                $editWhere['email'] = $userinfo['email'];
                $com->editdetail($editWhere,$company,$user);
            }
            return retmsg(0);
        }

    }

    public function releasePosition($data,$userinfo){
        $position = new \app\admin\model\WebUser();
        $data['welfare'] = implode(',',$data['welfare']);
        $ret = $position->releasePosition($data,$userinfo);
        $log['behavior'] = "发布职位";
        $log['create_time'] = date('Y-m-d H:i:s',time());
        $log['email'] = $userinfo['email'];
        if ($ret){
            $position->addLog($log);
            return retmsg(0);
        }else{
            return retmsg(-1);
        }
    }

    public function getPosition($where,$page,$pagesize,$timetype){
        $position = new \app\admin\model\WebUser();
        $ret = $position->getPosition($where,$page,$pagesize,$timetype);
        if ($ret){
            foreach ($ret['list'] as $k=>&$v){
                $v['welfare'] = explode(',',$v['welfare']);
            }
            return retmsg(0,$ret);
        }else{
            return retmsg(0);
        }
    }


    public function collection($postdata,$userinfo){
        $model = new \app\admin\model\WebUser();
        $data['position_id'] = $postdata['position_id'];
        $data['email'] = $userinfo['email'];
        $data['state'] = 1;
        $data['create_time'] = date('Y-m-d H:i:s',time());
        $where['position_id'] = $postdata['position_id'];
        $where['email'] = $userinfo['email'];
        $collect = $model->yishoucang($where);
        if($collect){
            return array("resultcode" => -1, "resultmsg" => "已收藏！", "data" => null);
        }else{
            $ret = $model->collection($data);
        }
        if ($ret){
            return retmsg(0);
        }else{
            return retmsg(-1);
        }
    }

    public function personalCenter($userinfo){
        $model = new \app\admin\model\WebUser();
        $email = $userinfo['email'];
        $ret = $model->personalCenter($email);
        if ($ret){
            return retmsg(0,$ret);
        }else{
            return retmsg(0);
        }
    }
    public function personalPosition($userinfo){
        $model = new \app\admin\model\WebUser();
        $email = $userinfo['email'];
        $ret = $model->personalPosition($email);
        if ($ret){
            foreach ($ret as $k=>&$v){
                $v['welfare'] = explode(',',$v['welfare']);
            }
            return retmsg(0,$ret);
        }else{
            return retmsg(0);
        }
    }

    public function positionBigtype($id){
        $model = new \app\admin\model\WebUser();
        $ret = $model->positionBigtype($id);
        $positiontype = Db::table('recruit_position_type')->field('pid,typename')->select();
        $positiontype = array_column($positiontype,'pid','typename');
        if ($ret){
            foreach ($ret as $k=>&$v){
                $v['potypeid'] = $positiontype[$v['industry']];
                $v['welfare'] = explode(',',$v['welfare']);
            }
            $list =array();$datalist =array();$data =array();
            foreach ($ret as $key=>$value){
                $list[$value['potypeid']][] = $value;
            }
            foreach ($list as $lk=>$lv){
                $datalist['id'] = $lk;
                $datalist['children'] = $lv;
                $data[] = $datalist;
            }
            return retmsg(0,$data);
        }else{
            return retmsg(0);
        }
    }

    public function positionDetail($id){
        $model = new \app\admin\model\WebUser();
        $ret = $model->positionDetail($id);
        if ($ret){
            foreach ($ret as $k=>&$v){
                $v['welfare'] = explode(',',$v['welfare']);
            }
            return retmsg(0,$ret);
        }else{
            return retmsg(0);
        }
    }

    public function releaseLiuyan($postdata,$userinfo){
        $position = new \app\admin\model\WebUser();
        $postdata['email'] = $userinfo['email'];
        $postdata['create_time'] = date('Y-m-d H:i:s',time());
        $ret = $position->releaseLiuyan($postdata);
        $log['behavior'] = "发布留言！";
        $log['create_time'] = date('Y-m-d H:i:s',time());
        $log['email'] = $userinfo['email'];
        if ($ret){
            $position->addLog($log);
            return retmsg(0);
        }else{
            return retmsg(-1);
        }
    }

    public function getLiuyan($userinfo){
        $model = new \app\admin\model\WebUser();
        $email =$userinfo['email'];
        $ret = $model->getLiuyan($email);
        if ($ret){
            return retmsg(0,$ret);
        }else{
            return retmsg(0);
        }
    }

    public function replyLiuyan($postdata,$userinfo){
        $position = new \app\admin\model\WebUser();
        $data['reply_email'] = $userinfo['email'];
        $data['reply_content'] = $postdata['reply_content'];
        $data['reply_time'] = date('Y-m-d H:i:s',time());
        $where['id'] = $postdata['id'];
        $ret = $position->replyLiuyan($data,$where);
        if ($ret){
            return retmsg(0);
        }else{
            return retmsg(-1);
        }
    }

    public function uploadResume($postdata,$userinfo){
        $position = new \app\admin\model\WebUser();
        $postdata['email'] = $userinfo['email'];
        $postdata['create_time'] = date('Y-m-d H:i:s',time());
        $ret = $position->uploadResume($postdata);
        if ($ret){
            return retmsg(0);
        }else{
            return retmsg(-1);
        }
    }
}