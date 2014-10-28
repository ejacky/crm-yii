<?php
class ContactHistory extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
    public function tableName()
    {
        return 'fu_crm_contact_history';
    }
    
    public function relations()
    {
        return array(             
        );
    }
    
    public function getContactHistoryInfo($searchInfo)
    { 
         $criteria = CDbCriteria();
         $criteria->condition = 'contact_id = :contactId and type = :type order by date desc';
         $criteria->params = array(
             ':contactId'=>$searchInfo['contact_id'],
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

    public function saveContactHistory($contactInfo, $udfInfo, $contactId, $type='', $currentContactInfo='')
    {
            //var_dump($currentContactInfo);exit;
        $diff = array();
        $criteria = new CDbCriteria();
        $criteria->condition = 'contact_id = :contactId order by date desc';
        $criteria->params = array(':contactId' => $contactId);
        $contactLogInfo = ContactLog::model()->find($criteria);
        
        if (isset($contactLogInfo))
        {
            $contactLogRecentInfo = json_decode($contactLogInfo->recentInfo);
        }
               
        if ($type == 'addTask')
        {
            $diff['name'] = Contact::model()->findByPk($contactId)->name;
            $diff['status'] = $contactInfo['contactType'];
        }
        
        if ($type == 'edit')
        {
                foreach ($contactInfo as $name => $value)
                {
                        //var_dump($currentContactInfo);exit;
                        if ($name)
                        {
                                $diff[$name] = array(
                                    'origi' => $currentContactInfo[$name],
                                    'now' => $contactInfo[$name],
                                    );       
                        }
                        
                }
                
// this is udf function , now it cann't work
//        foreach ($udfInfo as $name => $value)
//        {
//            if (isset($contactLogRecentInfo->$name))
//            {
//            if ($contactLogRecentInfo->$name != $contactInfo[$name])
//            {
//                $diff[$name] = array('origi' => $contactLogRecentInfo->$name, 'now' => $contactInfo[$name]);
//            }
//            }
//        }
        
        }
        
        if ($type == 'create')
        {
                foreach ($contactInfo as $name => $value)
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
        
        $this->contact_id = $contactId;
        $this->staff_id = Yii::app()->user->id;
        $this->date = date('Y-m-d H:i:s'); 
        $this->type = $type;
        $this->diff = json_encode($diff);
           
        $this->save();
    }
    
    
    public function fetchInfo($contactId, $contactType)
    {
         $criteria = new CDbCriteria();
         if ($contactType != 'all')
         {
             $criteria->condition = 'contact_id = :contactId and type = :type order by date desc';
             $criteria->params = array(
                 ':contactId'=>$contactId,
                 ':type' => $contactType,
                 );
         }
         else
         {
             $criteria->condition = 'contact_id = :contactId order by date desc';
             $criteria->params = array(
                 ':contactId'=>$contactId,
                 );
         }
         $item_count = contactHistory::model()->count($criteria);
         $pages = new CPagination($item_count);
         $pages->setPageSize(10);
         $pages->applyLimit($criteria);
         
         $model = $this->findAll($criteria);
         return $model;
    }
    
    public function showContactHistoryInfo($contactId, $contactType)
    {     
         $model = $this->fetchInfo($contactId, $contactType); 

         $html = '';
         foreach ($model as $sub)
         {
                 $toolsName = Tools::getTableTitles();

             if ($sub->type == 'create')
             {
                 $info = json_decode($sub->diff);
                 $html .= '
                 <table class="contact-browse">
                 <tr><td class="contact-browse" colspan="3">创建客户</td></tr>
                 <tr><th class="contact-browse" scope="col">表单项</th><th class="contact-browse" scope="col">数值</th></tr>
                 ';
                 foreach ($info as $name => $value)
                 { 
                         if ($name && $value != '')
                         {
                                 $html .= '<tr class="contact-browse"><td class="contact-browse">' . $toolsName[$name]. '名称：</td><td class="contact-browse">'. $value .'</td></tr>';
                         }
                     $str = explode('_', $name);
                     if ($str[0] == 'udf')
                     {
                         $dr = Yii::app()->db->createCommand('select * from pa_field where name = :name')->query(array(':name'=>$str[1]));
                         $row = $dr->read();
                         $html .= '<td>'. $row['label'] .'</td><td>'. $value .'</td>'; 
                     }
                 }
                 $html .= '<tr><td class="contact-browse">操作人：</td><td>'. Staff::model()->findByPk($sub->staff_id)->username .'</td></tr>';
                 $html .= '<tr><td class="contact-browse" colspan="2">创建日期：'. $sub->date .'</td></tr>';
                 $html .= '</table>';  
             }
             if ($sub->type == 'edit')
             {
                 $info = json_decode($sub->diff); 
                 $html .= '
                     <table class="contact-browse">
                     <tr class="contact-browse"><td class="contact-browse" colspan="3">编辑客户信息</td></tr>
                     <tr class="contact-browse"><th class="contact-browse" scope="col">表单项</th><th class="contact-browse" scope="col">原来数值</th><th class="contact-browse" scope="col">更改数值</th></tr>';
                 foreach ($info as $name => $value)
                 {
                         if ($name && $value->origi != $value->now)
                         {
                                 $html .= '<tr class="contact-browse"><td class="contact-browse">' . $toolsName[$name] . '</td><td class="contact-browse">原来为：'. $value->origi .'</td><td class="contact-browse">更改为：'. $value->now .'</td></tr>';
                         }
                         $str = explode('_', $name);
                         if ($str[0] == 'udf')
                         {
                                $dr = Yii::app()->db->createCommand('select * from pa_field where name = :name')->query(array(':name'=>$str[1]));
                                $row = $dr->read();
                                $html .= '<td>'. $row['label'] .'</td><td>原来为：' .$value->origi. '</td><td>更改为：'. $value->now.'</td>';
                         }
                 }
                 $html .= '<tr class="contact-browse"><td class="contact-browse" colspan="3">编辑日期:'. $sub->date .'</td></tr>';                 
                 $html .= '</table>';
             }
             
             if ($sub->type == 'addTask')
             {                     
                 $info = json_decode($sub->diff);
                 $html .= '
                 <table class="crm-task-browse">
                 <tr><td class="crm-task-browse" colspan="3">创建任务</td></tr>
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
    
    public function saveCrmTaskLog($taskId,$contactId)
    {
        $this->task_id = $taskId; 
        $this->contact_id = $contactId;
        $this->date = date("Y-m-d H:i:s");
        $this->save();
    }
}