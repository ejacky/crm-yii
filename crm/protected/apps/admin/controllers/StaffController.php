<?php
class StaffController extends Controller
{
	public $layout='//layouts/column2';
	public $tableName = 'staff-grid';
        
        public function actionIndex()
        {
                $this->render('index', array('name' => 'staffTable') );
        }

	public function actionAddStaff()
	{		
		$model = new Staff();
		$formfields = PaForm::model()->findByAttributes(array('name' => 'staff'))->formfields;
		$fields = PaForm::model()->findByAttributes(array('name' => 'staff'))->fields ;

		if (isset($_POST['form'])) {
			$model->saveAllStaffInfo($_POST['form']);
				$this->redirect('index');
		}
		$this->render('application.apps.core.form.components._dataFormUpdate', array(
			'fields' => $fields,
			'formFields' => $formfields,
			'model'=>$model
		));
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
	}

	public function actionfileDelete()
	{
		if (isset($_POST)){
			$attachment = new PaAttachment();
			$result = $attachment->deleteById($_POST['id']);
			echo $result;
		}
	}
	
	public function actionUpdateStaff()
	{
		$model = Staff::model()->findByPk($_GET['staff']);
		$formfields = PaForm::model()->findByAttributes(array('name' => 'staff'))->formfields;
		$fields = PaForm::model()->findByAttributes(array('name' => 'staff'))->fields ;

		if (isset($_POST['form'])) {
			//$sourceFormValue->sex = $_POST['form']['sex'];
			$model->saveAllStaffInfo($_POST['form']);
				$this->redirect('index');
		}
		$this->render('application.apps.core.form.components._dataFormUpdate', array(
			'fields' => $fields,
			'formFields' => $formfields,
			'model'=>$model
		));
	}
	
	public function actionDeleteStaff()
	{
		$model = Staff::model()->deleteByPk($_GET['staff']);
		$this->redirect('index');
	}
}