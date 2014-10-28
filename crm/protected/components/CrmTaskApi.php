<?php
/**
 * 
 * @author Jacky
 * fetch task infomation about task 
 */
class CrmTaskApi 
{
    static private function getCrmTaskModel()
    {
        return new CrmTask();
    }
    
    /**
     *
     * @param array $info
     * @return array 
     */ 
    static public function getCrmTaskInfo($info)
    {
        $model = self::getCrmTaskModel();
        return $model->getCrmTaskInfo($info);
    }
    /**
     *
     * @param array $crmTaskInfo
     * @param int $companyId
     * @param int $employeesId
     * @return boolean 
     */
    static public function saveCrmTask($crmTaskInfo, $companyId, $employeesId)
    {
        $model = self::getCrmTaskModel();
        return $model->saveCrmTask($crmTaskInfo, $companyId, $employeesId);
    }
}