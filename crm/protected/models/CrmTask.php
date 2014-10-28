<?php
class CrmTask extends CActiveRecord
{
    /**
     * @param type $className
     * @return CrmTask
     */
    
    public static function model($className = __CLASS__)
    {
    	return parent::model($className);
    }
    
    public function tableName()
    {
        return 'fu_crm_task';
    }
    
    public function relations()
    {
    	return array(
    	    'staff' => array(self::BELONGS_TO,'Staff','staff_id'),	  
    	);
    }
    
    public function saveCrmTaskInfo($info)
    {
//        var_dump($info);exit;
    	$this->client_id = $info['client_id'];
        $this->project_id = $info['project_id'];
    	$this->contact_id = $info['contact_id'];
  //    $this->name = $info['name'];
        $this->staff_id = $info['staff_id'];
        $this->contactType = $info['contactType'];
        $this->date = date("Y-m-d H:m:s");
        $isSave = $this->save(); 

        $staffId = $info['staff_id'];
        $clientId = $info['client_id']; 
        $contactId = $info['contact_id'];
        $type = 'addTask';

        $this->dealCalendar($info['contactType'], $type);
        $this->dealLog($info, $this->fetchUdfInfo($info), $clientId, $contactId, $type);
        

//        $taskRecord = new CompanyLog();
//        $taskRecord->saveCompanyLog($info, $arr=null, $companyId, $staffId, 'addTask');
        return $isSave;
    }
    
    private function dealLog($info, $udfInfo, $clientId, $contactId, $type)
    {
            $controllerName = Yii::app()->controller->id;
            if ($controllerName == 'client')
            {
                    $this->dealCompanyLog($info, $udfInfo, $clientId, $type);
            }
            if ($controllerName == 'contact')
            {
                    $this->dealContactLog($info, $udfInfo, $contactId, $type);
            }
    }
    
    private function fetchUdfInfo($info)
    {
            return '';
    }
    
    public function dealCompanyLog($info, $udfInfo, $clientId, $type)
    {
            $companyLog = new CompanyLog();
            $companyLog->saveCompanyLog($info, $udfInfo, $clientId, $type); 
    }
    
    public function dealContactLog($info, $udfInfo, $clientId, $type)
    {
            $contactLog = new ContactLog();
            $contactLog->saveContactLog($info, $udfInfo, $clientId, $type);
    }
    
    public function dealCalendar($taskName, $type)
    {
            $saveCalendar = new calendarApi();
            $userId = Yii::app()->user->id;
    }
    
    public function crmTaskToCalendar($info)
    {
        $calendarModel = new Calendar();
        $calendarModel->user_id = Yii::app()->user->id;
        $calendarModel->title = $info['contactType'];
        $calendarModel->startTime = date('y-m-d H:i:s');
        $calendarModel->repeatType = 'null';
        $calendarModel->dataType = 'sys';
        $calendarModel->save();
    }
    
    public function saveCrmTaskInfoInfoCalendar($info)
    {
        $calendarModel = new Calenadar();
        $calendarModel->user_id = Yii::app()->user->id;
        $calendarModel->title = $info['contactType'];
        $calendarModel->startTime = date('y-m-d H:i:s');
        $calendarModel->repeatType = 'null';
        $calendarModel->dataType = 'sys';
        $calendarModel->save();
    }
    
    public function getCrmTaskInfo($info = '')
    {
    	$criteria = new CDbCriteria;
    	if (!empty($info))
    	{
    	    if(!empty($info['company_id']))
    	    {
    	        $criteria->condition = 'company_id = :client_id and contact_id = :employee_id';
    	        $criteria->params = array(':company_id' => $info['company_id'], ':employee_id' => $info['id']);
    	    }
    	    else 
    	    {
    		$criteria->condition = 'client_id = :company_id';
    		$criteria->params = array(':company_id' => $info['id']);
    	    }    
    	}
    	
    	return parent::model(__CLASS__)->findAll($criteria);        
    }
}