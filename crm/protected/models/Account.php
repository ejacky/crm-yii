<?php
class Account extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
    public function tableName()
    {
        return 'fu_crm_account';
    }
    
    public function rules()
    {
        return array(
            array('name','required'),
            array('phone','length','min' => 3,'max' => 11),
            array('email','email'),
        );
    }
    
    public function relations()
    {
        return array(
            'company' => array(self::BELONGS_TO,'Company','company_id'),
            'crmTask' => array(self::BELONGS_TO,'CrmTask','task_id'),
        );
    }
    
    public function showAccountInfo()
    {
        return parent::model(__CLASS__)->findAll();
    }
    
    public function saveAccountInfo($account_info)
    {
        $this->name = $account_info['name'];        
        $this->company_id = $account_info['company_id'];
        $this->phone = $account_info['phone'];
        $this->email = $account_info['email'];
        $this->save();
    }
    
    public function saveCrmTask($taskInfo)
    {
    	$this->task_id = $taskInfo['task_id'];
    	$this->taskName = $this->crmTask->name;
        $this->plan = $taskInfo['plan'];
        $this->finish = $taskInfo['finish'];
        $this->save();
    }
}