<?php
class Client extends CActiveRecord
{	   
    public $task; 
    public $staffName;
    public $contact;
    public $contactPerson; 
    
    public function __construct($scenario = 'insert') {
        parent::__construct($scenario);
    }
    
    public static function model($className = __CLASS__)
    {
    	return parent::model($className);
    }
    
    public function rules()
    {
        return array(
        );
    }
//    
//    public function checkName($attribute,$params)
//    {
//        if ($this->findByAttributes(array('name' => $this->name)))
//        {
//            $this->addError($attribute, $params['message']); 
//        }
//    }
//    
//    public function checkPhone($attribute,$params)
//    {
//        if ($this->findByAttributes(array('phone' => $this->phone)))
//        {
//            $this->addError($attribute, $params['message']);
//        }
//    }
   
    public function tableName()
    {
        return 'fu_crm_client';
    }
    
    public function relations()
    {
        return array(
		'staff' => array(self::BELONGS_TO,'Staff','staff_id'),
	        'crmTask' => array(self::BELONGS_TO,'CrmTask','task_id'),
                'mycontact' => array(self::HAS_MANY,'Contact','client_id', 'index'=>'id'),
                'udf' => array(self::HAS_ONE,'Udf','formPrimaryIndex'),
        );
    }
    
    public function fetchUdf()
    {
        $criteria = new CDbCriteria();
        $criteria->select = 'DISTINCT name';
        $criteria->condition = 'distinguishForm = :nameSpace';
        $criteria->params = array(':nameSpace' => 'client');
        $model = Udf::model()->findAll($criteria);
        
        foreach ($model as $sub)
        {   
            $getBasicInfo[] = array(
                'name' => $this->fetchUdfName($sub->name),
                'value' => '$data->udf',
                );         
        }
        return $getBasicInfo;
    }
    
    public function fetchContactInfo()
    {
        $fetchAllContactInfo = $this->mycontact;
        $arr = array();
        if ($fetchAllContactInfo)
        {
        foreach ($fetchAllContactInfo as $fetchSubContactInfo)
        {
            $arr[] = CHtml::link($fetchSubContactInfo->name, array('account/contactBrowse?employee[id]='.$fetchSubContactInfo->id));
        }
        return implode(', ',$arr);
        }
        else {
        return '<a href=/index.php/contact/addContact?companyId='.$this->id.'>新增联系人</a>';
        }
    }
    
    public function saveClientInfo($info)
    {                       
               $type = $this->isNewRecord? 'create':'edit';               
               if ($type == 'edit')
               {
                       $currentClientInfo = $this->attributes;
               }
               else
               {
                       $currentClientInfo = '';
               }

               $otherInfo = array(
                   'staff_id' => Yii::app()->user->id,
                   'date' => date('Y-m-d H:m:s'),
               );
               $clientInfo = array_merge($otherInfo, $info);

               //this place can be replaced by '$this->attributes = $info', 
               //but now it cann't work. 
               foreach ($clientInfo as $name => $value)
               {
                       if ($name && $name != 'isNew')
                       {
                               $this->$name = $value;
                       }
               }
               $isSave = $this->save();
               
               $this->dealCalendar($info['name'], $type);
               $this->dealUdf($info, $this->id, $type);
               $this->dealCompanyLog($info, $this->fetchUdfInfo($info), $this->id, $type, $currentClientInfo);
               return $isSave;
    }
    
    public function fetchUdfInfo($clientInfo)
    {
            $udfInfo = array();
            foreach ($clientInfo as $name => $value)
            {
                    $str = explode('_',$name);           
                    if ($str[0] == 'udf')           
                    {             
                            $udfInfo[$name] = $value;        
                    }
            }
            return $udfInfo;
    }
    
    public function dealCompanyLog($info, $udfInfo ,$clientId, $type, $currentClientInfo = '')
    {
            $companyLog = new CompanyLog();
            $companyLog->saveCompanyLog($info, $udfInfo, $clientId, $type, $currentClientInfo); 
    }
    
    public function dealCalendar($taskName, $type)
    {
            $saveCalendar = new calendarApi();
            $userId = Yii::app()->user->id;
            $saveCalendar->saveCreateInfoInCalendar($taskName, $userId, $type);
    }
    
    public function dealUdf($info, $companyId, $type)
    {                 
        $udfModel = new Udf();
        $udfInfo = $this->fetchUdfInfo($info);
        
        if ($type == 'create')
        {
             $this->saveUdf($udfInfo, $companyId, 'client');
        }
        else if ($type == 'edit')
        {
            $this->editUdf($udfInfo, $companyId, 'client');
        } 
    }
    
    public function saveToCalender($info, $modelType)
    {
        $calendarModel = new Calendar();
        $calendarModel->user_id = Yii::app()->user->id;
        $calendarModel->title = $modelType . $info['name'];
        $calendarModel->startTime = date('y-m-d H:i:s');
        $calendarModel->repeatType = 'null';
        $calendarModel->dataType = 'sys';
        $calendarModel->save();
    }
    
    public function saveUdf($info, $formPrimaryIndex, $distinguishForm)
    {  
        foreach ($info as $name => $value)
        {
                $udfModel = new Udf();
                $udfModel->saveUdf($name, $value, $formPrimaryIndex, $distinguishForm);       
        }
    }
   
    public function editUdf($info, $formPrimaryIndex, $distinguishForm)
    {
         foreach ($info as $name => $value)
         {
            $criteria = new CDbCriteria();
            $criteria->condition = 'formPrimaryIndex = :formPrimaryIndex and distinguishForm = :distinguishForm and name = :name';
            $criteria->params = array(
                ':formPrimaryIndex' => $formPrimaryIndex,
                ':distinguishForm' => $distinguishForm,
                ':name' => $name,
                );
            Udf::model()->updateAll(array('value'=>serialize($value)), $criteria);
        }
         
     }
    
    public function getCompanyInfo()
    {
        return parent::model(__CLASS__)->findAll();    
    }
    
    public function addCrmTask($taskInfo)
    {
        $task = new CrmTask();
        $task->saveCrmTask($taskInfo);         
        $this->save();
    }
    
    public function search()
    {
        $criteria=new CDbCriteria;
        //$criteria->with = '';   
        $criteria->with = array('staff');
        $criteria->with = array('mycontact');
        $criteria->compare('staff.username',$this->staffName,true);
	$criteria->compare('name',$this->name,true);
	$criteria->compare('trade',$this->trade,true);
	$criteria->compare('address',$this->address,true);
	$criteria->compare('phone',$this->phone,true);
	$criteria->compare('email',$this->email,true);

	return new CActiveDataProvider($this, array(
	    'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => '20',
            ),
            'sort' => array('attributes'=>array('staffName'=>array('asc'=>'staff.username','desc'=>'staff.username Desc'),'*')),
		));
    }
    
    public function attributeLabels()
    {
                $defaultArray = Tools::getTableTitles();
		return $defaultArray;
        /*
	return array(
            'salesId' => '销售',
	    'name' => '名称',
            'phone' => '电话',
            'address' => '地址',
            'email' => '邮件',
            'staffName' => '负责员工',
            'task' => '录入任务',
            'trade' => '行业',
            'contactPerson' => '联系人',
	);
         * 
         */
    }
}
