<?php
class Contact extends CActiveRecord
{
    public $staffPerson;
    public $clientName;
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
    public function tableName()
    {
        return 'fu_crm_contact';
    }
    
    public function rules()
    {
        return array(
            array('name', 'required'),
            array('email', 'email'),
        );
    }
    
    public function relations()
    {
        return array(
            'company' => array(self::BELONGS_TO,'Client','client_id'),
	    'staff' => array(self::BELONGS_TO,'Staff','staff_id'),
	    'crmTask' => array(self::BELONGS_TO,'CrmTask','task_id'),
        );
    }
    
    public function getContactInfo()
    {
        return parent::model(__CLASS__)->findAll();
    }
    
    public function saveContactInfo1($info)
    {
            $otherInfo = array(
                   'staff_id' => Yii::app()->user->id,
                   'date' => date('Y-m-d H:m:s'),
            );
            $contactInfo = array_merge($otherInfo, $info);
            foreach ($contactInfo as $name => $value)
            {
                    if ($name)
                    {
                            $this->$name = $value;
                    }
            }
    
            $this->isNewRecord ? $modelType = 'create:' : $modelType = 'edit:';
            $calApi = new calendarApi();
            $userId = Yii::app()->user->id;
            $calApi->saveCreateInfoInCalendar($info['name'], $userId, $modelType);
            $calApi->saveBirthdayInCalendar($info['name'], $info['birthday'], $userId);
            return $this->save();
    }
    
    public function saveContactInfo($info)
    {                       
               $type = $this->isNewRecord? 'create':'edit';               
               if ($type == 'edit')
               {
                       $currentContactInfo = $this->attributes;
               }
               else
               {
                       $currentContactInfo = '';
               }

               $otherInfo = array(
                   'staff_id' => Yii::app()->user->id,
                   'date' => date('Y-m-d H:m:s'),
               );
               $contactInfo = array_merge($otherInfo, $info);

               //this place can be replaced by '$this->attributes = $info', 
               //but now it cann't work. 
               foreach ($contactInfo as $name => $value)
               {
                       if ($name)
                       {
                               $this->$name = $value;
                       }
               }
               $isSave = $this->save();

               $this->dealCalendar($info['name'], $type);
//               $this->dealUdf($info, $this->id, $type);
               $this->dealContactLog($info, $this->fetchUdfInfo($info), $this->id, $type, $currentContactInfo);
               return $isSave;
    }
    
    public function fetchUdfInfo($contactInfo)
    {
            $udfInfo = array();
            foreach ($contactInfo as $name => $value)
            {
                    $str = explode('_',$name);           
                    if ($str[0] == 'udf')           
                    {             
                            $udfInfo[$name] = $value;        
                    }
            }
            return $udfInfo;
    }
    
    public function dealContactLog($info, $udfInfo ,$clientId, $type, $currentClientInfo = '')
    {
            $companyLog = new ContactLog();
            $companyLog->saveContactLog($info, $udfInfo, $clientId, $type, $currentClientInfo); 
    }
           
    public function dealCalendar($taskName, $type, $birthday = '')
    {
            $saveCalendar = new calendarApi();
            $userId = Yii::app()->user->id;
            $saveCalendar->saveCreateInfoInCalendar($taskName, $userId, $type);
            
            if ($birthday != '')
            {
                    $this->saveToCalendarInbox($taskName, $birthday);
            }
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
    
    public function saveToCalendarInbox($name, $birthday)
    {
        $calendarModel = new Calendar();
        $calendarModel->user_id = Yii::app()->user->id;
        $calendarModel->title = $name . ' \'birthday';
        $calendarModel->allday = 1; 
        $calendarModel->startTime = $birthday;
        $calendarModel->startDate = $birthday;
        $calendarModel->dataType = 'inbox';
        $calendarModel->frequency = 1;
        $calendarModel->repeatType = 'year';
        $calendarModel->save();
    }
    
    public function saveContactInfoIntoCalendar($info, $modelType)
    {
        $calendarModel = new Calendar();
        $calendarModel->user_id = Yii::app()->user->id;
        $calendarModel->title = $modelType . $info['name'];
        $calendarModel->startTime = date('y-m-d H:i:s');
        $calendarModel->dataType = 'sys';
        $calendarModel->repeatType = 'null';
        $calendarModel->save();
    }
    
    public function search()
    {
        $criteria=new CDbCriteria;
        $criteria->with = array('staff');
	return new CActiveDataProvider($this, array(
	    'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => '20',
                ),
	    ));
    }
    
    public function attributeLabels()
    {
                $defaultArray = Tools::getTableTitles();
                $defaultArray['name'] = '名称';
		return $defaultArray;        
    }
}
