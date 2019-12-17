<?php
/**
 * Created by PhpStorm.
 * User: 000
 * Date: 2019/12/16
 * Time: 14:24
 */

namespace app\admin\logic;


class Resume
{
    public function getResumeList($companyName, $position)
    {
        $where = "select b.company_name company_name,c.title position_title,a.title resume_title,a.id,a.delivery_time                     from recurit_resume a 
                  left join recurit_company b on a.company_id = b.id
                  left join recurit_position c on a.position_id = c.id ";
        if (!empty($companyName)) {
            $where .= " where b.company like '%$companyName%' ";
        }
        if (!empty($registerAddr)) {
            $where .= empty($companyName) ? " where c.title like '%$position%' " : " and c.title like '%$position%' ";
        }
        $where .= ' order by company_name,position_title,delivery_time';
        $companyM = new \app\admin\model\Resume();
        $res = $companyM->selectResume($where);
        if (empty($res)) {
            return retmsg(-1, '', '查询数据为空');
        } else {
            return retmsg(0, $res, '查询成功');
        }
    }

    public function uploadResume($companyId, $positionId)
    {
        set_time_limit(0);
//        vendor("PHPExcel.Classes.PHPExcel");
        $file = $_FILES['file'] ['name'];
        $filetempname = $_FILES ['file']['tmp_name'];
        $file_size = $_FILES['file']['size'];
        if ($file_size > 5 * 1024 * 1024) {
            return retmsg(-1, '', '上传文件过大,请上传小于5M的文件');
        }
        $filePath = str_replace('\\', '/', realpath(__DIR__ . '/../../../')) . '/upload/';
        $filePath .= '/' . $companyId;
        if (!is_dir($filePath)) {
            mkdir($filePath);
        }
        $filename = explode(".", $file);
        $time = date("YmdHis");
        $filename [0] = $time;//取文件名t替换
        $name = implode(".", $filename); //上传后的文件名
        $uploadfile = $filePath . $name;
        $result = move_uploaded_file($filetempname, $uploadfile);
        if ($result) {
            $extension = substr(strrchr($file, '.'), 1);
            if ($extension != '' && $extension != 'xls' && $extension != 'csv') {
                $this->response(retmsg(-1, null, '请上传Excel或csv文件！'), 'json');
            }
        }
    }

    public function deleteResume($id)
    {
        $companyM = new \app\admin\model\Resume();
        $res = $companyM->deleteResume($id);
        if (empty($res)) {
            return retmsg(-1);
        } else {

            return retmsg(0);
        }
    }

    public function deleteResumeFile($file_url)
    {

    }
}