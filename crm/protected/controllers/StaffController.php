<?php
class StaffController extends Controller
{
	public $layout='//layouts/column2';
	public $tableName = 'staff-grid' ;
	public function actionIndex()
	{
		$model = new Staff();
		$model1 = PaField::model()->findAllByAttributes(array('nameSpace' => 'staff'));
		if (isset($_POST['field']))
		{
			if (FormHandler::saveFuCrmTable($_POST['field']))
			{
				$columns = FormHandler::fetchColumns($_POST['field']);
			}
		}
		else
		{
			$defaultCheck = array();
			foreach ($model1 as $sub)
			{
				if ($sub->category == 'basic')
				{
					$defaultCheck[] = $sub->name;
				}
			}
			$defaultCheck['tableName'] = $this->tableName;
			$defaultCheck['controller'] = $defaultCheck['action'] = 'staff';
			$columns = FormHandler::fetchColumns($defaultCheck);
		}
		$this->render('index',array(
             'model' => $model,
             'columns' => $columns,
             'model1' => $model1,
		));
	}

	public function actionAddStaff()
	{
		$model = Staff::model()->findByPk(Yii::app()->user->id);
		$formfields = PaForm::model()->findByPk(array(3))->formfields;
		$fields = PaForm::model()->findByPk(3)->fields ;

		if (isset($_POST['form'])) {
			$model->sex = $_POST['form']['sex'];
			$model->save();
				$this->redirect('index');
		}
		$this->render('application.components.form._dataForm', array(
			'fields' => $fields,
			'formFields' => $formfields,
			'model'=>$model
		));
	}

	public function actionlist()
	{
		$model = new Staff();
		if ($_POST['staff'])
		{
			if ($model->saveStaffInfo($_POST['staff']))
			{
				$this->redirect(array('account/index'));
			}
		}
		$this->render('list',array('model' => $model));
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
	}

	public function actionUpdateStaff()
	{
		$ret = FormView::getaddOption($_POST['name'], $_POST['label'], new Staff());
		echo "<table>".$ret."</table>";
	}
}