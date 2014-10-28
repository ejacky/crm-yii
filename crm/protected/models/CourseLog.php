<?php
class CourseLog extends CActiveRecord 
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
    public function tableName()
    {
        return 'in_tra_course_log';
    }
    
    public function saveCourseLog($courseInfo, $udfInfo, $courseId, $type, $currentCourseInfo)
    { 
        $this->saveInfoToCourseHistory($courseInfo, $udfInfo, $courseId, $type, $currentCourseInfo);
        $this->recentInfo = json_encode($courseInfo);
        $this->course_id = $courseId;    
        $this->staff_id = Yii::app()->user->id;
    	$this->date = date('Y-m-d H:i:s'); 
        
        $this->type = $type;  
        $this->save();  
    }
    
    private function saveInfoToCourseHistory($courseInfo, $udfInfo, $courseId, $type, $currentCourseInfo)
    {
            $courseHistoryModel = new CourseHistory();
            $courseHistoryModel->saveCourseHistory($courseInfo, $udfInfo, $courseId, $type, $currentCourseInfo);
    }
}