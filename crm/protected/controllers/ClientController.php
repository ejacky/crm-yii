<?php
class ClientController extends Controller
{
     public $layout = '//layouts/column2';
     
     public function actionIndex()
     { 
                 $this->render('index', array('name' => 'clientTable') );
     }
     
     public function actionAddClient()
     {
         	$model = new Client();
		$formfields = PaForm::model()->findByAttributes(array('name' => 'client'))->formfields;
		$fields = PaForm::model()->findByAttributes(array('name' => 'client'))->fields ;

		if (isset($_POST['form'])) { 
			if ($model->saveClientInfo($_POST['form'])) {
				$this->redirect('index');
			}
		}
		$this->render('application.apps.core.form.components._dataFormUpdate', array(
			'fields' => $fields,
			'formFields' => $formfields,
                    	'model'=>$model
                    ));	
     }
     
     public function actionEditClient()
     {
                $model = Client::model()->findByPk($_GET['clientId']);
		$formfields = PaForm::model()->findByAttributes(array('name' => 'client'))->formfields;
		$fields = PaForm::model()->findByAttributes(array('name' => 'client'))->fields ;

		if (isset($_POST['form'])) {
			if ($model->saveClientInfo($_POST['form'])) {
				$this->redirect('index');
			}
		}
		$this->render('application.apps.core.form.components._dataFormUpdate', array(
			'fields' => $fields,
			'formFields' => $formfields,
			'model'=>$model
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
		$this->render('application.apps.core.form.components._dataFormUpdate', array(
			'fields' => $fields,
			'formFields' => $formfields,
                    	'model'=>$model
                    ));	
     }
     
     public function actionClientBrowse()
     {
             //echo $_SERVER['HTTP_REFERER'];
             $clientId = isset($_GET['clientId'])?$_GET['clientId']:1;
     	 $detailCompanyModel = Client::model()->findByPk($clientId);
         $clientType = isset($_GET['companyHistoryType'])? $_GET['companyHistoryType'] : '<>';
         if (isset($_GET['clientId']))
         {
             $criteria = new CDbCriteria();
             $criteria->condition = 'client_id = :companyId and type = :type order by date desc';
             $criteria->params = array(
                 ':companyId'=>$_GET['clientId'],':type' => $clientType,
                 );           
             $item_count = companyHistory::model()->count($criteria);
             $pages = new CPagination($item_count);
             $pages->setPageSize(2);
             $pages->applyLimit($criteria);
             $getClientHistorys = companyHistory::model()->findAll($criteria);
         }
         
         if (strpos($_SERVER['HTTP_REFERER'], 'index'))
         {
                 $initHtml = CompanyHistory::model()->showCompanyHistoryInfo($clientId, 'all');
         }
         else 
         {
                 $initHtml = '';
         }


         $this->render('clientBrowse',array(
             'detailCompanyModel' => $detailCompanyModel, 
             'getClientHistorys' => $getClientHistorys,
             'pages' => $pages,
             'clientId' => $_GET['clientId'],
             'returnType' => $clientType,
             'returnCompany' => Client::model()->findByPk($_GET['clientId'])->name,
             'initHtml' => $initHtml,
         ));
     }
     
     public function actionShowHistoryAjax()
     {
         if ($_POST['clientId'])
         {
             echo CompanyHistory::model()->showCompanyHistoryInfo($_POST['clientId'], $_POST['companyHistoryType']);
         }
     }
     
//     public function actionUdf()
//     {
//         $model = new Udf();
//         if (isset($_POST['form']))
//         {
//             $this->saveUdf($_POST['form']);
//         }
//     }
//     
//     public function saveUdf($info)
//     {
//         $sql = '';
//        
//         foreach ($info as $name => $value)
//         {
//             $sql = 'insert into fu_crm_udf(nameSpace,name,value) values(:nameSpace,:name,:value)';
//             $parameters = array(':nameSpace' => 'client',':name' => $name, ':value' => $value);
//             Yii::app()->db->createCommand($sql)->execute($parameters);
//         } 
//     }
     
//    public function actionSaveTable()
//    {
//        if (isset($_POST['field']))
//        {
//            $tableModel = FormTable::model()->find('tableName = :tableName and staff_id = :staffId', array(
//                ':tableName' => 'Client-grid',
//                ':staffId' => Yii::app()->user->id,
//            ));
//            $tableModel->saveTable($_POST['field']);
//        }
//        $this->redirect('index');
//    }
     
     

}

