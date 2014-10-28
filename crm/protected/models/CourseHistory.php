<?php
class CourseHistory extends CActiveRecord 
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
    public function tableName()
    {
        return 'in_tra_course_history';
    }
    
    public function getCourseHistoryInfo($searchInfo)
    { 
         $criteria = CDbCriteria();
         $criteria->condition = 'course_id = :courseId and type = :type order by date desc';
         $criteria->params = array(
             ':courseId'=>$searchInfo['course_id'],
             ':type' => $searchInfo['type'],
             );
         
         return parent::model(__CLASS__)->findAll($criteria);
    }
    
    public function setPagination($criteria, $item_count, $listPerPage)
    {
        $pages = new CPagination($item_count, $listPerPage);
        $pages->setPageSize();
        $page->applyLimit($criteria);
        
        return $pages;
    }

    public function saveCourseHistory($courseInfo, $udfInfo, $courseId, $type='', $currentClientInfo='')
    {
            //var_dump($currentClientInfo);exit;
        $diff = array();
        $criteria = new CDbCriteria();
        $criteria->condition = 'course_id = :courseId order by date desc';
        $criteria->params = array(':courseId' => $courseId);
        $courseLogInfo = CourseLog::model()->find($criteria);
        
        if (isset($courseLogInfo))
        {
            $courseLogRecentInfo = json_decode($courseLogInfo->recentInfo);
        }
               
        if ($type == 'addTask')
        {
            $diff['name'] = Client::model()->findByPk($courseId)->name;
            $diff['status'] = $courseInfo['contactType'];
        }
        
        if ($type == 'edit')
        {
                foreach ($courseInfo as $name => $value)
                {
                        //var_dump($currentClientInfo);exit;
                        if ($name)
                        {
                                $diff[$name] = array(
                                    'origi' => $currentClientInfo[$name],
                                    'now' => $courseInfo[$name],
                                    );       
                        }
                        
                }
                
// this is udf function , now it cann't work
//        foreach ($udfInfo as $name => $value)
//        {
//            if (isset($companyLogRecentInfo->$name))
//            {
//            if ($companyLogRecentInfo->$name != $companyInfo[$name])
//            {
//                $diff[$name] = array('origi' => $companyLogRecentInfo->$name, 'now' => $companyInfo[$name]);
//            }
//            }
//        }
        
        }
        
        if ($type == 'create')
        {
                foreach ($courseInfo as $name => $value)
                {
                        $diff[$name] = $value;
                }      
            
            if ($udfInfo)
            {
                foreach ($udfInfo as $name => $value)
                {
                    $diff[$name] = $value;
                }
            }
        }
        
        $this->course_id = $courseId;
        $this->staff_id = Yii::app()->user->id;
        $this->date = date('Y-m-d H:i:s'); 
        $this->type = $type;
        $this->diff = json_encode($diff);
           
        $this->save();
    }
    
    
    
    public function showCourseHistoryInfo($clientId, $clientType)
    {
         $criteria = new CDbCriteria();
         if ($clientType != 'all')
         {
             $criteria->condition = 'course_id = :courseId and type = :type order by date desc';
             $criteria->params = array(
                 ':courseId'=>$clientId,
                 ':type' => $clientType,
                 );
         }
         else
         {
             $criteria->condition = 'course_id = :courseId order by date desc';
             $criteria->params = array(
                 ':courseId'=>$clientId,
                 );
         }
         $item_count = CourseHistory::model()->count($criteria);
         $pages = new CPagination($item_count);
         $pages->setPageSize(10);
         $pages->applyLimit($criteria);
         
         $model = $this->findAll($criteria);
         
         $html = '';
         foreach ($model as $sub)
         {
                 $toolsName = Tools::getTableTitles();
             if ($sub->type == 'create')
             {
                 $info = json_decode($sub->diff);
                 $html .= '
                 <table class="course-browse">
                 <tr><td class="course-browse" colspan="3">创建客户</td></tr>
                 <tr><th class="course-browse" scope="col">表单项</th><th class="course-browse" scope="col">数值</th></tr>
                 ';
                 foreach ($info as $name => $value)
                 { 
                         if ($name && $value != '')
                         {
                                 $html .= '<tr class="course-browse"><td class="course-browse">' . $toolsName[$name]. '名称：</td><td class="course-browse">'. $value .'</td></tr>';
                         }
                     $str = explode('_', $name);
                     if ($str[0] == 'udf')
                     {
                         $dr = Yii::app()->db->createCommand('select * from pa_field where name = :name')->query(array(':name'=>$str[1]));
                         $row = $dr->read();
                         $html .= '<td>'. $row['label'] .'</td><td>'. $value .'</td>'; 
                     }
                 }
                 $html .= '<tr><td class="course-browse">操作人：</td><td>'. Staff::model()->findByPk($sub->staff_id)->username .'</td></tr>';
                 $html .= '<tr><td class="course-browse" colspan="2">创建日期：'. $sub->date .'</td></tr>';
                 $html .= '</table>';  
             }
             if ($sub->type == 'edit')
             {
                 $info = json_decode($sub->diff); 
                 $html .= '
                     <table class="course-browse">
                     <tr class="course-browse"><td class="course-browse" colspan="3">编辑客户信息</td></tr>
                     <tr class="course-browse"><th class="course-browse" scope="col">表单项</th><th class="course-browse" scope="col">原来数值</th><th class="course-browse" scope="col">更改数值</th></tr>';
                 foreach ($info as $name => $value)
                 {
                         if ($name && $value->origi != $value->now)
                         {
                                 $html .= '<tr class="course-browse"><td class="course-browse">' . $toolsName[$name] . '</td><td class="course-browse">原来为：'. $value->origi .'</td><td class="course-browse">更改为：'. $value->now .'</td></tr>';
                         }
                         $str = explode('_', $name);
                         if ($str[0] == 'udf')
                         {
                                $dr = Yii::app()->db->createCommand('select * from pa_field where name = :name')->query(array(':name'=>$str[1]));
                                $row = $dr->read();
                                $html .= '<td>'. $row['label'] .'</td><td>原来为：' .$value->origi. '</td><td>更改为：'. $value->now.'</td>';
                         }
                 }
                 $html .= '<tr class="course-browse"><td class="course-browse" colspan="3">编辑日期:'. $sub->date .'</td></tr>';                 
             }
             $html .= '</table>';
             if ($sub->type == 'addTask')
             {
                 $info = json_decode($sub->diff);
                 $html .= '
                 <table class="crm-task-browse">
                 <tr><td class="crm-task-browse" colspan="3">创建客户</td></tr>
                 <tr><th class="crm-task-browse" scope="col">表单项</th><th class="crm-task-browse" scope="col">数值</th></tr>
                     ';
                 foreach ($info as $name => $value)
                 {
                     if ($name == 'name')
                     {
                         $html .= '<tr class="crm-task-browse"><td class="crm-task-browse">记录类型</td><td>'. $value .'</td></tr>';
                     }
                     if ($name == 'staff_id')
                     {
                         $html .= '<tr class="crm-task-browse" class="alt"><td>负责员工</td><td class="crm-task-browse">'. Staff::model()->findByPk($value)->username .'</td></tr>';
                     }
                     if ($name == 'status')
                     {
                         $html .= '<tr class="crm-task-browse"><td class="crm-task-browse">任务状态</td><td class="crm-task-browse">'. $value .'</td></tr>';
                     }
                 }
                 $html .= '<tr><td class="crm-task-browse" colspan="2">创建日期:'. $sub->date .'</td></tr>';
                 $html .= '</table>';
             }         
         }
         /*
          $html .= Yii::app()->controller->widget('CLinkPager', array(
              'pages' => $pages,
          ));
          * 
          */
          return $html;   
    }
    
    public function saveCrmTaskLog($taskId,$courseId)
    {
        $this->task_id = $taskId; 
        $this->course_id = $courseId;
        $this->date = date("Y-m-d H:i:s");
        $this->save();
    }
}