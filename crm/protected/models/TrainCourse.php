<?php
class TrainCourse extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
    public function tableName()
    {
        return 'in_tra_course';
    }
    
    public function relations()
    {
        return array(
            'lecturer' => array(self::BELONGS_TO, 'TrainLecturer', 'lecturer_id'),
            'contact' => array(self::BELONGS_TO, 'Contact', 'contact_id'),
        );
    }
    
//    public function saveCourseInfo($info)
//    {
////            $this->attributes = $info;
////            $this->save();exit;
//        $type = $this->isNewRecord ? 'createCourse' : 'editCourse';
//        $this->lecturer_id = $info['lecturerId'];
//        $this->contact_id = $info['contactId'];
//        if (isset($info['followCourseId']))
//        {
//            $this->followCourseId = json_encode($info['followCourseId']);
//        }
//        
//        $this->courseName = $info['courseName'];
//        $this->courseAddress = $info['courseAddress'];
//        $this->courseTime = $info['courseTime'];
//        $this->contactPhone = $info['contactPhone'];
//        $this->courseVideo = $info['courseVideo'];
//
//        $isSave = $this->save();
//
//        if ($type == 'createCourse')
//        {
//            $this->saveCourseLog($info, 'createCourse', $this->id);
//        }
//        return $isSave;
//    }
    
    public function saveCourseInfo($info)
    {                       
               $type = $this->isNewRecord? 'create':'edit';               
               if ($type == 'edit')
               {
                       $currentCourseInfo = $this->attributes;
               }
               else
               {
                       $currentCourseInfo = '';
               }

               $otherInfo = array(
                   'followCourseId' => json_encode($info['followCourseId']),
               );
               
               //may be have two followCourseId.
               $CourseInfo = array_merge($otherInfo, $info);

               //this place can be replaced by '$this->attributes = $info', 
               //but now it cann't work. 
               foreach ($CourseInfo as $name => $value)
               {
                       if ($name)
                       {
                               $this->$name = $value;
                       }
               }
               $isSave = $this->save();

               $this->dealCourseLog($info, $this->fetchUdfInfo($info), $this->id, $type, $currentCourseInfo);
               return $isSave;
    }
    
    public function dealCourseLog($info, $udfInfo ,$clientId, $type, $currentClientInfo = '')
    {
            $companyLog = new CourseLog();
            $companyLog->saveCourseLog($info, $udfInfo, $clientId, $type, $currentClientInfo); 
    }
    
    public function fetchUdfInfo($CourseInfo)
    {
            $udfInfo = array();
            foreach ($CourseInfo as $name => $value)
            {
                    $str = explode('_',$name);           
                    if ($str[0] == 'udf')           
                    {             
                            $udfInfo[$name] = $value;        
                    }
            }
            return $udfInfo;
    }
    
    public function fetchFollowPersonInfo()
    {
        $followCourseJason = $this->followCourseId;
        $followPersonArray = json_decode($followCourseJason);
        $followPersonName = '';
        $displayFollowPerson = '';
        if (is_array($followPersonArray)) 
        {
        foreach ($followPersonArray as $key => $value)
        {
            $followPersonName = Staff::model()->findByPk($value)->username;
            $displayFollowPerson .= $followPersonName . ' ';
        }
        }
        else 
        {
            $displayFollowPerson = Staff::model()->findByPk($followPersonArray)->username;
        }
        return $displayFollowPerson;
    }
    
    /*
    public function updateTrainCourseInfo($updateInfo,$pk)
    {
        return $this->updateByPk(array(
    	    'courseName'=>$updateInfo['courseName'],
    	    'courseAddress'=>$updateInfo['courseAddress'],
    	),$pk);
    }
     */
    
    public function saveCourseLog($info, $type, $courseId)
    {
         $model = new CourseLog();
         $model->saveLogInfo($info, $type, $courseId);
    }
    
    public function search()
    {
        $criteria=new CDbCriteria;

	return new CActiveDataProvider($this, array(
	    'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => '20',
                ),
             ));
    }
    
    public function attributeLabels()
    {
        return array(
        );
    }
}
