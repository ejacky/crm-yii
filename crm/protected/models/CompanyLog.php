<?php
class CompanyLog extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
    public function tableName()
    {
        return 'fu_crm_client_log';
    }
    
    public function saveCompanyLog($companyInfo, $udfInfo, $companyId, $type, $currentClientInfo='')
    { 
            $this->saveInfoToCompanyHistory($companyInfo, $udfInfo, $companyId, $type, $currentClientInfo);
            $this->recentInfo = json_encode($companyInfo);
            $this->client_id = $companyId;    
            $this->staff_id = Yii::app()->user->id;
       	    $this->date = date('Y-m-d H:i:s'); 
        
            $this->type = $type;  
            $this->save();  
    }
    
    
    private function saveInfoToCompanyHistory($companyInfo, $udfInfo, $companyId, $type, $currentClientInfo)
    {
            $companyHistoryModel = new CompanyHistory();
            $companyHistoryModel->saveCompanyHistory($companyInfo, $udfInfo, $companyId, $type, $currentClientInfo);
    }
}
