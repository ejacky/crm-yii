<?php
class Category extends CActiveRecord
{

	public $position;

	/**
	 *
	 * @param type $className
	 * @return Category
	 */
	public static function model($className=__class__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'pa_multiple_level_category';
	}

	public function relations()
	{
		return array(
			'deTitle'=>array(self::HAS_ONE, 'DepartmentTitle', 'departmentID'),
		);
	}

	public function attributeLabels()
	{
		
		$defaultArray = Tools::getTableTitles();
		$defaultArray['name'] = '部门名称';
		return $defaultArray;
	}
}
