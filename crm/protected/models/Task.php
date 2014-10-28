<?php
class Task extends CActiveRecord
{
	/**
	 *
	 * @param type $className
	 * @return Task
	 */
	public static function model($className=__class__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'co_task';
	}

	public function relations()
	{
		return array(
			'role'=>array(self::MANY_MANY, 'Role', 'co_role_task(task_id, role_id)' ),
		);
	}
	/**
	 * get all tasks by current org id.
	 * @return type
	 public function getAllTasks($orgId = null)
	 {
		if (!$orgId)
		{
		$orgId = Yii::app()->user->orgId;
		}

		return Task::model()->findAll(array('condition' => 'org_id='.$orgId));
		}
		*/

	public function attributeLabels()
	{
		$defaultArray = Tools::getTableTitles();
        return $defaultArray;
	}
}
