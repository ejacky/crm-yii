<?php
class Property extends CActiveRecord
{
	public static function model($className=__class__)
	{
		return parent::model($className);
	}
	
	public function tableName()
	{
		return 'co_property';
	}
}
