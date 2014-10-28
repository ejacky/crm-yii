<?php

class TableSetController extends Controller {
	public $layout = '//layouts/column2';
	
	public function actionIndex() {
		$this->render('index');
	}
	
	public function actionExample() {
		$this->render('example', array('name' => $_GET['name']) );
	}
	
	public function actionTableIndex()
	{
		if (isset($_GET['name']))
		{
			$sourceFormValue = TableModel::model()->findByAttributes(array('name' => $_GET['name']));
		}
		else
		{
			$sourceFormValue = new TableModel();
		}
		
		$formfields = PaForm::model()->findByAttributes(array('name' => 'coreTable'))->formfields;
		$fields = PaForm::model()->findByAttributes(array('name' => 'coreTable'))->fields ;

		if (isset($_POST['form']))
		{
			if (isset($_GET['name']))
			{
				$tableName = $sourceFormValue->updateFormInfo();
			}
			else
			{
				$tableName = $sourceFormValue->insertFormInfo();
			}
			$this->redirect('example?name='.$tableName);
		}
		
		$this->render('tableIndex', array(
			'fields' => $fields,
			'formFields' => $formfields,
			'model'=>$sourceFormValue
			));
	}
	
	public function actionExecuteSql()
	{
		$result = TableHelper::executeSql($_POST['sql']);
		if ($_POST['name'])
		{
			$model = TableItemModel::model()->findAllByAttributes(array('table_name' => $_POST['name']));
		}
		else
		{
			$model = new TableItemModel;
		}
		$this->renderPartial('columnDisplay', array('result' => $result, 'model' => $model));
	}
	
	public function actionRender()
	{
		$name = $_GET['name'];
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$condition = isset($_GET['condition']) ? $_GET['condition'] : '';
		$orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : '';
		$this->renderPartial('application.apps.core.table.components.table', array('name' => $name, 'page' => $page, 'orderBy' => $orderBy, 'condition' => $condition));
		exit;
	}

}