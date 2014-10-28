<?php
class UserTask extends CActiveRecord
{
	/**
	 * 
	 * @param type $className
	 * @return UserTask
	 */
	public static function model($className=__class__)
	{
		return parent::model($className);
	}
	
	public function tableName()
	{
		return 'co_user_task';
	}
	
	public function relations() {
		return array(
			'task' => array(self::BELONGS_TO, 'Task', 'task_id')
		);
	}
	
	public function getUserTasks($userId = null)
	{
		if (!$userId)
		{
			$userId = Yii::app()->user->id;
		}

		$tasks = $this->with('task')->findAll(array('condition' => 'user_id = '.$userId));
		$data = array();
		
		foreach ($tasks as $task)
		{
			$data[] = $task->task->system_name;
		}
		
		return $data;
	}
}
