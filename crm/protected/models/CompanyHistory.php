<?php
class CompanyHistory extends CActiveRecord
{
    /**
     *
     * @param type $className
     * @return CompanyHistory 
     */

    
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
    public function tableName()
    {
        return 'fu_crm_client_history';
    }
    
    public function relations()
    {
        return array(
            'company' => array(self::BELONGS_TO,'Client','client_id'),
            'crmTask' => array(self::BELONGS_TO,'CrmTask','task_id'),
        );
    }
    
    public function getCompanyHistoryInfo($searchInfo)
    { 
         $criteria = CDbCriteria();
         $criteria->condition = 'client_id = :companyId and type = :type order by date desc';
         $criteria->params = array(
             ':companyId'=>$searchInfo['company_id'],
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

    public function saveCompanyHistory($companyInfo, $udfInfo, $companyId, $type='', $currentClientInfo='')
    {
            //var_dump($currentClientInfo);exit;
        $diff = array();
        $criteria = new CDbCriteria();
        $criteria->condition = 'client_id = :companyId order by date desc';
        $criteria->params = array(':companyId' => $companyId);
        $companyLogInfo = CompanyLog::model()->find($criteria);
        
//        if (isset($companyLogInfo))
//        {
//            $companyLogRecentInfo = json_decode($companyLogInfo->recentInfo);
//        }
               
        if ($type == 'addTask')
        {
                foreach ($companyInfo as $name => $value)
                {
                        if ($name == 'client_id')
                        {
                                $diff['clientName'] = Client::model()->findByPk($value)->name;
                        }
                        if ($name == 'contact_id')
                        {
                                $diff['contactName'] = Contact::model()->findByPk($value)->name;
                        }
                        if ($name == 'contactType')
                        {
                                $diff['contactType'] = $companyInfo['contactType'];
                        }
                }


        }
        
        if ($type == 'edit')
        {
                foreach ($companyInfo as $name => $value)
                {
                        //var_dump($currentClientInfo);exit;
                        if ($name)
                        {
                                $diff[$name] = array(
                                    'origi' => $currentClientInfo[$name],
                                    'now' => $companyInfo[$name],
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
                foreach ($companyInfo as $name => $value)
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
        
        $this->client_id = $companyId;
        $this->staff_id = Yii::app()->user->id;
        $this->date = date('Y-m-d H:i:s'); 
        $this->type = $type;
        $this->diff = json_encode($diff);
           
        $this->save();
    }
    
    private function fetchInfo($clientId, $clientType)
    {
         $criteria = new CDbCriteria();
         if ($clientType != 'all')
         {
             $criteria->condition = 'client_id = :companyId and type = :type order by date desc';
             $criteria->params = array(
                 ':companyId'=>$clientId,
                 ':type' => $clientType,
                 );
         }
         else
         {
             $criteria->condition = 'client_id = :companyId order by date desc';
             $criteria->params = array(
                 ':companyId'=>$clientId,
                 );
         }
         $item_count = companyHistory::model()->count($criteria);
         $pages = new CPagination($item_count);
         $pages->setPageSize(10);
         $pages->applyLimit($criteria);
         
         $model = $this->findAll($criteria);
            
         return $model;
    }
    
    public function showCompanyHistoryInfo($clientId, $clientType)
    {
         $model = $this->fetchInfo($clientId, $clientType);
         
         $html = '';
         foreach ($model as $sub)
         {
             $toolsName = Tools::getTableTitles();
             if ($sub->type == 'create')
             {          
              //   $this->test();
                 $info = json_decode($sub->diff);
                 $html .= '
                 <table class="company-browse">
                 <tr><td class="company-browse" colspan="3">创建客户</td></tr>
                 <tr><th class="company-browse" scope="col">表单项</th><th class="company-browse" scope="col">数值</th></tr>
                 ';
                 foreach ($info as $name => $value)
                 { 
                         if ($name && $value != '')
                         {
                                 $html .= '<tr class="company-browse"><td class="company-browse">' . $toolsName[$name]. '名称：</td><td class="company-browse">'. $value .'</td></tr>';
                         }
                     $str = explode('_', $name);
                     if ($str[0] == 'udf')
                     {
                         $dr = Yii::app()->db->createCommand('select * from pa_field where name = :name')->query(array(':name'=>$str[1]));
                         $row = $dr->read();
                         $html .= '<td>'. $row['label'] .'</td><td>'. $value .'</td>'; 
                     }
                 }
                 $html .= '<tr><td class="company-browse">操作人：</td><td>'. Staff::model()->findByPk($sub->staff_id)->username .'</td></tr>';
                 $html .= '<tr><td class="company-browse" colspan="2">创建日期：'. $sub->date .'</td></tr>';
                 $html .= '</table>';  
                     $this->fetchCreate($sub);
             }
             if ($sub->type == 'edit')
             {
                 $info = json_decode($sub->diff); 
                 $html .= '
                     <table class="company-browse">
                     <tr class="company-browse"><td class="company-browse" colspan="3">编辑客户信息</td></tr>
                     <tr class="company-browse"><th class="company-browse" scope="col">表单项</th><th class="company-browse" scope="col">原来数值</th><th class="company-browse" scope="col">更改数值</th></tr>';
                 foreach ($info as $name => $value)
                 {
                         if ($name && $value->origi != $value->now)
                         {
                                 $html .= '<tr class="company-browse"><td class="company-browse">' . $toolsName[$name] . '</td><td class="company-browse">原来为：'. $value->origi .'</td><td class="company-browse">更改为：'. $value->now .'</td></tr>';
                         }
                         $str = explode('_', $name);
                         if ($str[0] == 'udf')
                         {
                                $dr = Yii::app()->db->createCommand('select * from pa_field where name = :name')->query(array(':name'=>$str[1]));
                                $row = $dr->read();
                                $html .= '<td>'. $row['label'] .'</td><td>原来为：' .$value->origi. '</td><td>更改为：'. $value->now.'</td>';
                         }
                 }
                 $html .= '<tr class="company-browse"><td class="company-browse" colspan="3">编辑日期:'. $sub->date .'</td></tr>';   
                 $html .= '</table>';
              //       $this->fetchEdit($sub);
             }
            
             if ($sub->type == 'addTask')
             {
                 $info = json_decode($sub->diff);
                 $html .= '
                 <table class="crm-task-browse">
                 <tr><td class="crm-task-browse" colspan="3">创建联系记录</td></tr>
                 <tr><th class="crm-task-browse" scope="col">表单项</th><th class="crm-task-browse" scope="col">数值</th></tr>
                     ';
                 foreach ($info as $name => $value)
                 {
                     if ($name == 'clientName')
                     {
                         $html .= '<tr class="crm-task-browse"><td class="crm-task-browse">客户名称</td><td>'. $value .'</td></tr>';
                     }
                     if ($name == 'contactName')
                     {
                         $html .= '<tr class="crm-task-browse"><td class="crm-task-browse">联系人名称</td><td>'. $value .'</td></tr>';
                     }
                     if ($name == 'staff_id')
                     {
                         $html .= '<tr class="crm-task-browse" class="alt"><td>负责员工</td><td class="crm-task-browse">'. Staff::model()->findByPk($value)->username .'</td></tr>';
                     }
                     if ($name == 'status')
                     {
                         $html .= '<tr class="crm-task-browse"><td class="crm-task-browse">联系类型</td><td class="crm-task-browse">'. $value .'</td></tr>';
                     }
                 }
                 $html .= '<tr><td class="crm-task-browse" colspan="2">创建日期:'. $sub->date .'</td></tr>';
                 $html .= '</table>';
                     
 //                $this->fetchAddTask($sub);
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
    
    public function test()
    {
            return 'tstss';
    //        return $a;
    }
    
    public function fetchCreate($sub)
    {
                 $toolsName = Tools::getTableTitles();
                 $info = json_decode($sub->diff);
                 $html = '';
                 $html .= '
                 <table class="company-browse">
                 <tr><td class="company-browse" colspan="3">创建客户</td></tr>
                 <tr><th class="company-browse" scope="col">表单项</th><th class="company-browse" scope="col">数值</th></tr>
                 ';
                 foreach ($info as $name => $value)
                 { 
                         if ($name && $value != '')
                         {
                                 $html .= '<tr class="company-browse"><td class="company-browse">' . $toolsName[$name]. '名称：</td><td class="company-browse">'. $value .'</td></tr>';
                         }
                     $str = explode('_', $name);
                     if ($str[0] == 'udf')
                     {
                         $dr = Yii::app()->db->createCommand('select * from pa_field where name = :name')->query(array(':name'=>$str[1]));
                         $row = $dr->read();
                         $html .= '<td>'. $row['label'] .'</td><td>'. $value .'</td>'; 
                     }
                 }
                 $html .= '<tr><td class="company-browse">操作人：</td><td>'. Staff::model()->findByPk($sub->staff_id)->username .'</td></tr>';
                 $html .= '<tr><td class="company-browse" colspan="2">创建日期：'. $sub->date .'</td></tr>';
                 $html .= '</table>';
                 
                 return $html;
    }
    
    private function fetchEdit($sub)
    {            
                 $toolsName = Tools::getTableTitles();
                 $info = json_decode($sub->diff); 
                 $html = '';
                 $html .= '
                     <table class="company-browse">
                     <tr class="company-browse"><td class="company-browse" colspan="3">编辑客户信息</td></tr>
                     <tr class="company-browse"><th class="company-browse" scope="col">表单项</th><th class="company-browse" scope="col">原来数值</th><th class="company-browse" scope="col">更改数值</th></tr>';
                 foreach ($info as $name => $value)
                 {
                         if ($name && $value->origi != $value->now)
                         {
                                 $html .= '<tr class="company-browse"><td class="company-browse">' . $toolsName[$name] . '</td><td class="company-browse">原来为：'. $value->origi .'</td><td class="company-browse">更改为：'. $value->now .'</td></tr>';
                         }
                         $str = explode('_', $name);
                         if ($str[0] == 'udf')
                         {
                                $dr = Yii::app()->db->createCommand('select * from pa_field where name = :name')->query(array(':name'=>$str[1]));
                                $row = $dr->read();
                                $html .= '<td>'. $row['label'] .'</td><td>原来为：' .$value->origi. '</td><td>更改为：'. $value->now.'</td>';
                         }
                 }
                 $html .= '<tr class="company-browse"><td class="company-browse" colspan="3">编辑日期:'. $sub->date .'</td></tr>';   
                 $html .= '</table>';
                 
                 return $html;
            
    }
    
    private function fetchAddTask($sub)
    {
                 return 'aabb';
                 $info = json_decode($sub->diff);
                 $html = '';
                 $html .= '<table class="crm-task-browse"><tr><td class="crm-task-browse" colspan="3">创建联系记录</td></tr><tr><th class="crm-task-browse" scope="col">表单项</th><th class="crm-task-browse" scope="col">数值</th></tr>';
                 foreach ($info as $name => $value)
                 {
                     if ($name == 'clientName')
                     {
                         $html .= '<tr class="crm-task-browse"><td class="crm-task-browse">客户名称</td><td>'. $value .'</td></tr>';
                     }
                     if ($name == 'contactName')
                     {
                         $html .= '<tr class="crm-task-browse"><td class="crm-task-browse">联系人名称</td><td>'. $value .'</td></tr>';
                     }
                     if ($name == 'staff_id')
                     {
                         $html .= '<tr class="crm-task-browse" class="alt"><td>负责员工</td><td class="crm-task-browse">'. Staff::model()->findByPk($value)->username .'</td></tr>';
                     }
                     if ($name == 'status')
                     {
                         $html .= '<tr class="crm-task-browse"><td class="crm-task-browse">联系类型</td><td class="crm-task-browse">'. $value .'</td></tr>';
                     }
                 }
                 $html .= '<tr><td class="crm-task-browse" colspan="2">创建日期:'. $sub->date .'</td></tr>';
                 $html .= '</table>';
                 
                 return $html;
            
    }
    
    public function fetchLogInfo()
    {
            
    }
    
    public function saveCrmTaskLog($taskId,$companyId)
    {
        $this->task_id = $taskId; 
        $this->client_id = $companyId;
        $this->date = date("Y-m-d H:i:s");
        $this->save();
    }
}
