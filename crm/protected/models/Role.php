<?php
class Role extends CActiveRecord
{
	public $task_system_name;
	public $task_display_name;
	
	/**
	 *
	 * @param type $className
	 * @return Role 
	 */
	public static function model($className=__class__)
	{
		return parent::model($className);
	}
	
	public function tableName()
	{
		$this->setTableAlias('role');
		return 'co_role';
	}
	
	public function relations()
	{
		return array(
			'task'=>array(self::MANY_MANY, 'Task', 'co_role_task(role_id, task_id)',)// 'select' => 'GROUP_CONCAT(taskSystemName SEPARATOR "，") as taskSystemName', ),
		);
	}
	
	public function getRoleTaskIdArray()
	{
		$models = $this->with('task')->findAll();
		$data = array();
		foreach ($models as $model)
		{
			foreach ($model['task'] as $taskModel)
			{
				$data[$model->id][] = $taskModel->id;
			}
		}
		
		return $data;
	}
	
	public function attributeLabels()
	{
		$defaultArray = Tools::getTableTitles();
		return $defaultArray;
	}
}
