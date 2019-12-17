<?php
/**
 * Created by PhpStorm.
 * User: 000
 * Date: 2019/12/16
 * Time: 14:24
 */

namespace app\admin\model;


use think\Db;

class Resume
{
    private static $table = 'recurit_resume';

    public function selectResume($where)
    {
        $res = Db::query($where);
        return $res;
    }

    public function deleteResume($id)
    {
        $res = Db::table(self::$table)
            ->delete($id);
        return $res;
    }

    public function uploadResume($data)
    {
        $ret = Db::table('recruit_resume')->insert($data);
        return $ret;
    }

    public function selectResumeUrl($id)
    {
        $res = Db::table(self::$table)
            ->field('file_url')
            ->where('id', $id)
            ->select();
        return $res;
    }
}