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
}