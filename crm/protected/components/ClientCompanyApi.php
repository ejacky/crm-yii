<?php

/**
 *
 *  @author Jacky
 *  fectch information about company
 */
class ClientCompanyApi 
{
    static private function getCompanyModel($scenario = null)
    {
        return new Company($scenario);
    }
    /**
     * @return array 
     */
    static public function getCompanyInfo()
    {
        $model = self::getCompanyModel();       
        return $model->getCompanyInfo();
    }
     
    /**
     *
     * @param array $companyInfo
     * @return boolean 
     */
    
    static public function addCompany($companyInfo)
    {
        $model = self::getCompanyModel('add');
        return $model->saveCompanyInfo($companyInfo);   
    }
    
}
?>
