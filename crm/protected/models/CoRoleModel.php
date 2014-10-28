<?php
class CoRoleModel extends AdminModel
{
	public $roleTask;
	
	/**
	 *
	 * @return CoRoleModel
	 */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
    public function tableName()
    {
        return 'co_role';
    }
	
	public function saveData()
	{
		if ($this->isNew())
		{
			if (!self::model()->findByAttributes(array('name' => $_POST['form']['name']))){
				$model = new CoRoleModel();
				$model->name = $_POST['form']['name'];
				$model->displayName = $_POST['form']['displayName'];
				$model->description = $_POST['form']['description'];
				$model->save();
			}
			
			foreach ($_POST['form']['roleTask'] as $task)
			{
				$model = new CoRoleTaskModel();
				$model->role_name = $_POST['form']['name'];
				$model->task_name = $task;
				$model->save();
			}
		}
		else
		{
			CoRoleTaskModel::model()->deleteAllByAttributes(array('role_name' => $_POST['form']['name']));
			
			foreach ($_POST['form']['roleTask'] as $task)
			{
				$model = new CoRoleTaskModel();
				$model->role_name = $_POST['form']['name'];
				$model->task_name = $task;
				$model->save();
			}
			unset($_POST['form']['roleTask']);
			
			$model = self::model()->findByAttributes(array('name' => $_POST['form']['name']));
			$model->saveAttributes($_POST['form']);

		}
	}
}
