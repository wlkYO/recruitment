<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/12/16
 * Time: 16:43
 */

namespace app\admin\model;


use think\Db;

class Advertise
{
    private static $table = 'recruit_advertise';

    public function getAdverurl()
    {
        $ret = Db::table('recruit_advertise')->field('id,advert_title,url')->select();
        return $ret;
    }

    public function addAdvert($data)
    {
        $ret = Db::table(self::$table)
            ->insert($data);
        return $ret;
    }

    public function deleteAdvert($id)
    {
        $ret = Db::table(self::$table)
            ->delete($id);
        return $ret;
    }

    public function updateAdvert($data)
    {
        $ret = Db::table(self::$table)
            ->update($data);
        return $ret;
    }
}