<?php
class ContactController extends Controller
{
    public $layout = '//layouts/column2';
    
    public function actionIndex()
    {
                 $this->render('index', array('name' => 'contactTable') );
    }
    
	public function actionAddContact()
	{
		$model = new Contact();
		$formfields = PaForm::model()->findByAttributes(array('name' => 'contact'))->formfields;
		$fields = PaForm::model()->findByAttributes(array('name' => 'contact'))->fields ;

		if (isset($_POST['form'])) {
			if ($model->saveContactInfo($_POST['form'])) {
				$this->redirect('index');
			}
		}
		$this->render('application.apps.core.form.components._dataFormUpdate', array(
			'fields' => $fields,
			'formFields' => $formfields,
                    	'model'=>$model
                    ));		
	}
    

      
    public function actionEditContact()
    {
                $model = Contact::model()->findByPk($_GET['contactId']);
		$formfields = PaForm::model()->findByAttributes(array('name' => 'contact'))->formfields;
		$fields = PaForm::model()->findByAttributes(array('name' => 'contact'))->fields ;

		if (isset($_POST['form'])) {
			if ($model->saveContactInfo($_POST['form'])) {
				$this->redirect('index');
			}
		}
		$this->render('application.components.form._dataFormUpdate', array(
			'fields' => $fields,
			'formFields' => $formfields,
			'model'=>$model
		));
    }
    
    public function actionDeleteContact()
    {
        Contact::model()->findByPk($_GET['contactId'])->delete();
        $this->redirect('index');
    }
    
     public function actionView()
     {        
         $this->render('view',array('model' => Contact::model()->findByPk($_GET['employee_id'])));
     }
     
     public function actionDelete()
     {
         Contact::model()->findByPk($_GET['employee_id'])->delete();
         
         $this->redirect('index');
     }
     
     public function actionEditLog()
     {
     	 $model = new ContactLog();
         $this->render('editLog', array(
             'showEmployeesLogs' => $model->showEmployeesLogInfo(),
             ));
     }
     
     public function actionAddTask()
     {
         	$model = new CrmTask();
		$formfields = PaForm::model()->findByAttributes(array('name' => 'task'))->formfields;
		$fields = PaForm::model()->findByAttributes(array('name' => 'task'))->fields ;

		if (isset($_POST['form'])) {
			if ($model->saveCrmTaskInfo($_POST['form'])) {
				$this->redirect('index');
			}
		}
		$this->render('application.components.form._dataFormUpdate', array(
			'fields' => $fields,
			'formFields' => $formfields,
                    	'model'=>$model
                    ));	
     }
     
     public function actionContactBrowse()
     {
             //echo $_SERVER['HTTP_REFERER'];
             $contactId = isset($_GET['contactId'])?$_GET['contactId']:1;
     	 $detailContactModel = Contact::model()->findByPk($contactId);
         $contactType = isset($_GET['contactHistoryType'])? $_GET['contactHistoryType'] : '<>';
         if (isset($_GET['contactId']))
         {
             $criteria = new CDbCriteria();
             $criteria->condition = 'contact_id = :contactId and type = :type order by date desc';
             $criteria->params = array(
                 ':contactId'=>$_GET['contactId'],':type' => $contactType,
                 );           
             $item_count = contactHistory::model()->count($criteria);
             $pages = new CPagination($item_count);
             $pages->setPageSize(2);
             $pages->applyLimit($criteria);
             $getContactHistorys = contactHistory::model()->findAll($criteria);
         }
         
         if (strpos($_SERVER['HTTP_REFERER'], 'index'))
         {
                 $initHtml = ContactHistory::model()->showContactHistoryInfo($contactId, 'all');
         }
         else 
         {
                 $initHtml = '';
         }


         $this->render('contactBrowse',array(
             'detailContactModel' => $detailContactModel, 
             'getContactHistorys' => $getContactHistorys,
             'pages' => $pages,
             'contactId' => $_GET['contactId'],
             'returnType' => $contactType,
             'returnContact' => Contact::model()->findByPk($_GET['contactId'])->name,
             
             'initHtml' => $initHtml,
         ));
     }
     
     public function actionShowHistoryAjax()
     {
         if ($_POST['contactId'])
         {
              //   echo $_POST['contactHistoryType'];
             echo ContactHistory::model()->showContactHistoryInfo($_POST['contactId'], $_POST['contactHistoryType']);
         }
     }
          

     
//     public function actionSaveTable()
//    {
//        if (isset($_POST['field']))
//        {
//            $tableModel = FormTable::model()->find('tableName = :tableName and staff_id = :staffId', array(
//                ':tableName' => 'contact-grid',
//                ':staffId' => Yii::app()->user->id,
//            ));
//            $tableModel->saveTable($_POST['field']);
//        }
//        $this->redirect('index');
//    }
}
