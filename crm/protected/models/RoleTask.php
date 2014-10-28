<?php
class RoleTask extends CActiveRecord
{
	public static function model($className=__class__)
	{
		return parent::model($className);
	}
	
	public function tableName()
	{
		$this->setTableAlias('role_task');
		return 'co_role_task';
	}
}
