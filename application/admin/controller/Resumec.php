<?php
/**
 * Created by PhpStorm.
 * User: 000
 * Date: 2019/12/16
 * Time: 14:00
 */

namespace app\admin\controller;


use app\admin\logic\Resume;

class Resumec
{
    public function getResumeList($companyName = '', $position= '')
    {
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $companyLogic = new Resume();
        $result = $companyLogic->getResumeList($companyName, $position);
        return $result;
    }

    public function deleteResume($id){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $companyLogic = new Resume();
        $result = $companyLogic->deleteResume($id);
        return $result;
    }

    public function uploadResume($companyId,$positionId){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $companyLogic = new Resume();
        $result = $companyLogic->uploadResume($companyId,$positionId);
        return $result;
    }
}