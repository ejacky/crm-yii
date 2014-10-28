<?php

class AuthController extends Controller
{
	public $layout='//layouts/column2';
	private $title = 'crm-title' ;
	private $role = 15 ;
	private $task = 14 ;
	private $department = 13 ;

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionUserCreate()
	{
		if ($_POST)
		{
			if (!$_POST['userId'])
			{
				Yii::app()->user->setFlash('pageInfo', "请选择用户！");
				$this->redirect(array('auth/userList'));
			}
			$model = new UserDepartmentTitle;
			$model->user_id = $_POST['userId'];
			$model->departmentID = $_POST['departmentId'];
			$model->title = $_POST['title'];
			$model->insert();

			if ($_POST['task'])
			{
				foreach($_POST['task'] as $taskId => $checkValue)
				{
					$model = new UserTask();
					$model->task_id = $taskId;
					$model->user_id = $_POST['userId'];
					$model->save();
				}
			}

			if ($_POST['role'])
			{
				foreach($_POST['role'] as $roleId => $checkValue)
				{
					$model = new UserRole();
					$model->role_id = $roleId;
					$model->user_id = $_POST['userId'];
					$model->save();
				}
			}

			$this->redirect(array('auth/userList'));

		}
		else
		{
			$category = new CoCategory();
			$allCategories = $category->getTree('department');
			$departmentData = array('data' => $this->convertToJsTreeFormat($allCategories));

			$departmentTitleInfo = DepartmentTitle::model()->getRelation();

			$roles = Role::model()->with('task')->findAll();

			$roleTaskIds = Role::model()->getRoleTaskIdArray();
			$tasks = Task::model()->findAll();

			$users = User::model()->findall();

			$this->render('userCreate',array(
				'users' => $users,
				'departmentData' => json_encode($departmentData),
				'departmentTitleInfo' => json_encode($departmentTitleInfo),
				'roles' => $roles,
				'tasks' => $tasks,
				'roleTaskIds' => json_encode($roleTaskIds),
			));
		}
	}

	public function actionUserList()
	{
		$parameter = array('order' => 'user.id DESC',
					'select' => array(
						'*',
		));

		$userDepartmentTitleInfo = UserDepartmentTitle::model()->with(array('user', 'department', 'title'))->findall($parameter);

		$this->render('userList',array(
			'userDepartmentTitleInfo' => $userDepartmentTitleInfo,
		));
	}

	public function actionUserEdit()
	{
		$user = User::model()->with(array('role', 'task', 'department', 'title'))->findByPk($_GET['id']);

		$category = new CoCategory();
		$allCategories = $category->getTree('department');
		$departmentData = array('data' => $this->convertToJsTreeFormat($allCategories));

		$departmentTitleInfo = DepartmentTitle::model()->getRelation();

		$roles = Role::model()->with('task')->findAll();

		$roleTaskIds = Role::model()->getRoleTaskIdArray();
		$tasks = Task::model()->findAll();

		$this->render('userEdit',array(
			'user'=>$user,
			'departmentData' => json_encode($departmentData),
			'departmentTitleInfo' => json_encode($departmentTitleInfo),
			'roles' => $roles,
			'tasks' => $tasks,
			'roleTaskIds' => json_encode($roleTaskIds),
		));
	}

	public function actionUserDelete()
	{
		if (CMSPrivilegeApi::init()->have('system'))
		{
			UserDepartmentTitle::model()->deleteByPk($_GET['id']);

			Yii::app()->user->setFlash('pageInfo', "用户部门、职位、权限信息已删除");
			$this->redirect('/admin.php/auth/userList');
		}
	}

	public function actionDepartmentList()
	{
		$getBasicInfo = array();
		$getBasicInfo[] = 'name';
		$getBasicInfo[] = 'deTitle.title';
		$getBasicInfo[] = array(
			'class' => 'CButtonColumn',
			'header' => '操作',
			'template'=>'{update} {delete}',
			'updateButtonUrl'=>'Yii::app()->createUrl("auth/DepartmentUpdate",array("department"=>$data->id))',
			'deleteButtonUrl'=>'Yii::app()->createUrl("auth/DepartmentDelete",array("department"=>$data->id))',
			'deleteButtonLabel'=>'删除',
			'updateButtonLabel'=>'编辑',
		);
		$criteria=new CDbCriteria;
		$criteria->addCondition('name_space="department"');
		$criteria->with = 'deTitle';
		$model1 = new CActiveDataProvider( 'category', array( 'criteria'=>$criteria ) );
		$this->render( 'departmentList',array(
			 'model' => $model1,
			 'columns' => $getBasicInfo,
		));
	}

	public function actionDepartmentDelete()
	{
		$category = new CoCategory();
		$result = $category->deleteCategory($_GET['department']);
		if ($result['error'])
		{
			Yii::app()->user->setFlash('errorInfo', $result['message']);
			$this->redirect(array('auth/departmentList'));
		}
		else
		{
			DepartmentTitle::model()->deleteAllByAttributes(array('departmentID' => $_GET['department']));
			Yii::app()->user->setFlash('pageInfo', "部门已经删除");
			$this->redirect(array('auth/departmentList'));
		}
	}

	public function actionDepartmentCreate()
	{
		$sourceFormValue = new DepartmentTitle();
		$formfields = PaForm::model()->findByPk($this->department)->formfields;
		$fields = PaForm::model()->findByPk($this->department)->fields ;

		if (isset($_POST['form'])) {
			$highTtile = isset($_POST['form']['highDepartment']) ? $_POST['form']['highDepartment'] : '' ;
			$result = CoCategory::init()->save('department', $_POST['form']['name'], $highTtile);
			if (!$result['error'])
			{
				if (isset($_POST['form']['title']))
				{
					$title = implode(',', $_POST['form']['title'] ) ;
					$model = new DepartmentTitle();
					$model->departmentID = $result['id'];
					$model->title = $title;
					$model->insert();
				}
				$this->redirect(array('auth/departmentList'));
			}
			else
			{
				$this->refresh();
			}
		}

		$this->render('application.components.form._dataForm', array(
			'fields' => $fields,
			'formfields' => $formfields,
			'sourceFormValue'=>$sourceFormValue
		));
	}

	public function actionDepartmentUpdate()
	{
		if ($_POST)
		{
			$category = new CoCategory();
			$highTtile = isset($_POST['form']['highDepartment']) ? $_POST['form']['highDepartment'] : '' ;
			$category->updateCategory($_GET['department'], array('name' => $_POST['form']['name']));
			$title = implode(',', $_POST['form']['title'] ) ;
			$model = DepartmentTitle::model()->find('departmentID=:id', array(':id'=>$_GET['department']));
			$model->departmentID = $_GET['department'];
			$model->title = $title;
			$model->update();
			$this->redirect(array('auth/departmentList'));
		}
		else
		{
			$criteria = new CDbCriteria;
			$criteria->with = 'deTitle';
			//$criteria->select = 't.name as department, deTitle.title as title' ;
			$criteria->addCondition('t.id='.$_GET['department']) ;
			$model = Category::model()->find($criteria);
			$model1 = PaField::model()->findAllByAttributes(array('nameSpace' => 'property'));
			$this->render('_form',array(
				'model' => $model,
				'model1' => $model1,
				'exValue'=> CoCategory::init()->getAll('department'),
				'exKeyValue'=>'deTitle',
				'groupList' => FieldGroup::model()->findAllByAttributes(array('nameSpace' => 'property')),	   
			));
		}
	}

	public function actionTitleList()
	{
		$roleInfo = Role::model()->with('task')->findAll(array('group' => 'role.id', 'select' => '*, GROUP_CONCAT(task.systemName SEPARATOR "，") as task_systemName, GROUP_CONCAT(task.displayName SEPARATOR "，") as task_displayName'));

		$this->render('titleList',array(
			'roleInfo' => $roleInfo
		));
	}

	public function actionTitleCreate()
	{
		if ($_POST)
		{
			$model = new DepartmentTitle();
			$model->deleteAll('departmentID=:departmentID', array(':departmentID' => $_POST['departmentId']));

			foreach ($_POST['title'] as $oneTitle)
			{
				$model = new DepartmentTitle();
				$model->departmentID = $_POST['departmentId'];
				$model->title = $oneTitle;
				$model->insert();
			}
			$this->refresh();
		}
		else
		{
			$category = new CoCategory();
			$allCategories = $category->getTree('department');
			$departmentData = array('data' => $this->convertToJsTreeFormat($allCategories));

			$titleInfo = Property::model()->find('name=:name', array(':name' => 'title'));

			$departmentTitleInfo = DepartmentTitle::model()->getRelation();

			$this->render('titleCreate',array(
				'allCategories'=>$allCategories, 'departmentData' => json_encode($departmentData), 'departmentTitleInfo' => json_encode($departmentTitleInfo), 'titleInfo' => explode(',', $titleInfo->value), 'type' => 'create'
				));
		}
	}

	public function actionRoleList()
	{
		$criteria=new CDbCriteria;
		$criteria->with = 'task';
		//$criteria->select = 'GROUP_CONCAT(task.taskSystemName SEPARATOR "，") as taskSystemName';
		$model1 = new CActiveDataProvider( 'role', array( 'criteria'=>$criteria ) );
		$defaultCheck['tableName'] = 'task-grid';
		$defaultCheck['controller'] = 'auth';
		$defaultCheck['action'] = 'role';
		$columns = FormHandler::fetchColumns($defaultCheck, 'role', array('taskSystemName'));
		$this->render( 'taskList',array(
			 'model' => $model1,
			 'columns' => $columns,
		));
	}

	public function actionRoleCreate()
	{
		$sourceFormValue = new Role();
		$formfields = PaForm::model()->findByPk($this->role)->formfields;
		$fields = PaForm::model()->findByPk($this->role)->fields ;

		if (isset($_POST['form'])) {
			foreach (Role::model()->findAll() as $model)
			{
				if ($model->roleSystemName == $_POST['form']['roleSystemName'])
				{
					Yii::app()->user->setFlash('errorInfo', "您使用的角色（权限组）名：“{$model->systemName}”已经存在");
					$this->refresh();
				}
			}
			$model = new Role;
			$model->roleSystemName = $_POST['form']['roleSystemName'];
			$model->roleDisplayName = $_POST['form']['roleDisplayName'];
			$model->roleDescription = $_POST['form']['roleDescription'];
			$model->save();
			if (isset($_POST['form']['taskSystemName']))
			{
				foreach ($_POST['form']['taskSystemName'] as $taskId)
				{
					$model->task = new RoleTask;
					$model->task->role_id = $model->id;
					$model->task->task_id = $taskId;
					$model->task->save();
				}
			}
			$this->redirect(array('auth/roleList'));
		}

		$this->render('application.components.form._dataForm', array(
			'fields' => $fields,
			'formfields' => $formfields,
			'sourceFormValue'=>$sourceFormValue
		));
	}

	public function actionUpdateRole()
	{
		if ($_POST)
		{
			foreach (Role::model()->findAll() as $model)
			{
				if ($model->id != $_POST['id'] && $model->systemName == $_POST['systemName'])
				{
					Yii::app()->user->setFlash('errorInfo', "您想编辑的角色（权限组）名：“{$model->systemName}”已经存在");
					$this->redirect(CHttpRequest::getUrlReferrer());
				}
			}

			$model = new Role;
			$model->updateByPk($_POST['id'], array('systemName' => $_POST['systemName'], 'displayName' => $_POST['displayName'], 'description' => $_POST['description']));

			if (isset($_POST['tasks']))
			{
				$task = new RoleTask;
				$task->deleteAllByAttributes(array('role_id' => $_POST['id']));

				foreach ($_POST['tasks'] as $taskId)
				{
					$model->task = new RoleTask;
					$model->task->role_id = $_POST['id'];
					$model->task->task_id = $taskId;
					$model->task->save();
				}
			}

			Yii::app()->user->setFlash('pageInfo', "角色（权限组）编辑成功");
			$this->redirect('/admin.php/auth/roleEdit?id='.$_POST['id']);
		}
		else
		{
			$criteria = new CDbCriteria;
			$criteria->addCondition('role.id='.$_GET['role']) ;
			$criteria->with = 'task';
			$model = Role::model()->find($criteria);
			//var_dump($model);exit;
			$model1 = PaField::model()->findAllByAttributes(array('nameSpace' => 'role'));
			$this->render('_form',array(
				'model' => $model,
				'model1' => $model1,
				'exKeyValue'=> 'task',
				'groupList' => FieldGroup::model()->findAllByAttributes(array('nameSpace' => 'role')),	   
			));
		}
	}

	public function actionDeleteRole()
	{
		$model = new Role;
		$model->deleteByPk($_GET['role']);

		$model = new RoleTask();
		$model->deleteAllByAttributes(array('role_id' => $_GET['role']));

		Yii::app()->user->setFlash('pageInfo', "角色（权限组）已删除");
		$this->redirect(array('auth/roleList'));
	}

	protected function convertToJsTreeFormat($categories)
	{
		$data = array();
		foreach ($categories as $category)
		{
			$array['data'] = $category['model']->name;
			$array['metadata'] = array("id" => $category['model']->id, "name" => $category['model']->name);
			$array['children'] = $this->convertToJsTreeFormat($category['children']);
			$array['attr']['id'] = 'department'.$category['model']->id;
			if (empty($array['children']))
			{
				$array['attr']['rel'] = 'tail';
			}

			$data[] = $array;
		}

		return $data;
	}

	public function actionProperty()
	{
		if ($_POST)
		{
			CMSPropertyApi::init()->update($this->title, 0, $_POST['form']['title']);
			$this->refresh();
		}
		else
		{
			$model1 = PaField::model()->findAllByAttributes(array('nameSpace' => 'title'));
			$this->render('_form',array(
				'model' => Property::model()->find('nameSpace=:name', array(':name'=>$this->title)) ,
				'model1' => $model1,
				'groupList' => FieldGroup::model()->findAllByAttributes(array('nameSpace' => 'title')),  
			));
		}
	}

	public function actionTaskList()
	{
		$criteria=new CDbCriteria;
		$model1 = new CActiveDataProvider( 'task', array( 'criteria'=>$criteria ) );
		$defaultCheck['tableName'] = '';
		$defaultCheck['controller'] = 'auth';
		$defaultCheck['action'] = 'task';
		$columns = FormHandler::fetchColumns($defaultCheck, 'task');
		$this->render( 'taskList',array(
			 'model' => $model1,
			 'columns' => $columns,
		));
	}

	public function actionTaskCreate()
	{
		$sourceFormValue = new Task();
		$formfields = PaForm::model()->findByPk($this->task)->formfields;
		$fields = PaForm::model()->findByPk($this->task)->fields ;

		if (isset($_POST['form'])) {
			foreach (Task::model()->findAll() as $model)
			{
				if ($model->taskSystemName == $_POST['form']['taskSystemName'])
				{
					Yii::app()->user->setFlash('errorInfo', "您使用的权限名：“{$model->systemName}”已经存在");
					$this->refresh();
				}
			}
			$model = new Task;
			$model->taskSystemName = $_POST['form']['taskSystemName'];
			$model->taskDisplayName = $_POST['form']['taskDisplayName'];
			$model->taskDescription = $_POST['form']['taskDescription'];
			$model->insert();
			$this->redirect(array('auth/taskList'));
		}

		$this->render('application.components.form._dataForm', array(
			'fields' => $fields,
			'formfields' => $formfields,
			'sourceFormValue'=>$sourceFormValue
		));
	}

	public function actionUpdateTask()
	{
		if ($_POST)
		{
			$model = Task::model()->find('taskSystemName=:name', array(':name'=>$_POST['form']['taskSystemName']));
			$model->taskDisplayName = $_POST['form']['taskDisplayName'];
			$model->taskDescription = $_POST['form']['taskDescription'];
			$model->update();
			$this->redirect(array('auth/taskList'));
		}
		else
		{
			$criteria = new CDbCriteria;
			$criteria->addCondition('t.id='.$_GET['task']) ;
			$model = Task::model()->find($criteria);
			$model1 = PaField::model()->findAllByAttributes(array('nameSpace' => 'task'));
			$this->render('_form',array(
				'model' => $model,
				'model1' => $model1,
				'groupList' => FieldGroup::model()->findAllByAttributes(array('nameSpace' => 'task')),	   
			));
		}
	}

	public function actionDeleteTask()
	{
		$model = new Task();
		$model->deleteByPk($_GET['task']);
		$this->redirect(array('auth/taskList'));
	}
}
