<?php
class ContactLog extends CActiveRecord
{
    public static function model($className = __CLASS__)
	{
	    return parent::model($className);
	}
	
	public function tableName()
	{   
	    return 'fu_crm_contact_log';
	}
	
    public function saveContactLog($contactInfo, $udfInfo, $contactId, $type, $currentContactInfo = '')
    { 
        $this->saveInfoToContactHistory($contactInfo, $udfInfo, $contactId, $type, $currentContactInfo);
        $this->recentInfo = json_encode($contactInfo);
        $this->contact_id = $contactId;    
        $this->staff_id = Yii::app()->user->id;
    	$this->date = date('Y-m-d H:i:s'); 
        
        $this->type = $type;  
        $this->save();  
    }
    
    private function saveInfoToContactHistory($contactInfo, $udfInfo, $contactId, $type, $currentContactInfo = '')
    {
            $contactHistoryModel = new ContactHistory();
            $contactHistoryModel->saveContactHistory($contactInfo, $udfInfo, $contactId, $type, $currentContactInfo);
    }
}