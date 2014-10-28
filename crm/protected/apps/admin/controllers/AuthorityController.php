<?php

class AuthorityController extends AdminController
{
	public function actionTaskList()
	{
		$this->render('taskList', array('tableName' => 'coTask'));
	}
	
	public function actionTaskMaker()
	{
		if (isset($_GET['name']))
		{
			$model = CoTaskModel::model()->findByAttributes(array('name' => $_GET['name']));
		}
		else
		{
			$model = new CoTaskModel();
		}

		if ($this->isPost())
		{
			$model->saveData();
			$this->redirect('taskList');
		}

		$this->render('taskMaker', array(
			'formName' => 'coTask',
			'model'=>$model
			));
	}
	
	public function actionRoleList()
	{
		$this->render('roleList', array('tableName' => 'coRole'));
	}
	
	public function actionRoleMaker()
	{
		if (isset($_GET['name']))
		{
			$model = CoRoleModel::model()->findByAttributes(array('name' => $_GET['name']));
			$taskRoles = CoRoleTaskModel::model()->findAllByAttributes(array('role_name' => $_GET['name']));
			$roleArray = array();
			foreach ($taskRoles as $role)
			{
				$roleArray[] = $role->task_name;
			}
			
			$model->roleTask = implode(',', $roleArray);
		}
		else
		{
			$model = new CoRoleModel();
		}

		if ($this->isPost())
		{
			$model->saveData();
			$this->redirect('roleList');
		}

		$this->render('roleMaker', array(
			'formName' => 'coRole',
			'model'=>$model
			));
	}
}
