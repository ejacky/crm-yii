<?php

class OrganizationController extends AdminController
{
	public function actionPositionList()
	{
		$this->render('positionList', array('tableName' => 'position'));
	}
	
	public function actionPositionMaker()
	{
		if (isset($_GET['name']))
		{
			$model = PositionModel::model()->findByAttributes(array('name' => $_GET['name']));
		}
		else
		{
			$model = new PositionModel();
		}

		if ($this->isPost())
		{
			$model->saveData();
			$this->redirect('positionList');
		}

		$this->render('positionMaker', array(
			'formName' => 'position',
			'model'=>$model
			));
	}
	
	public function actionDepartmentList()
	{
		$this->render('departmentList', array('tableName' => 'department'));
	}
	
	public function actionDepartmentMaker()
	{
		if (isset($_GET['name']))
		{
			$model = DepartmentModel::model()->findByAttributes(array('name' => $_GET['name']));
		}
		else
		{
			$model = new DepartmentModel();
		}

		if ($this->isPost())
		{
			$model->saveData();
			$this->redirect('departmentList');
		}

		$this->render('departmentMaker', array(
			'formName' => 'department',
			'model'=>$model
			));
	}
}
