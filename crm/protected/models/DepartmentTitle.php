<?php
class DepartmentTitle extends CActiveRecord
{
	/**
	 *
	 * @param type $className
	 * @return DepartmentTitle 
	 */
	public static function model($className=__class__)
	{
		return parent::model($className);
	}
	
	public function tableName()
	{
		return 'co_department_title';
	}
	
	public function getRelation()
	{
		$this->relations();
		$allInfo = $this->findAll();
		$data = array();
		foreach ($allInfo as $info)
		{
			$data[$info->department_id][] = $info->title;
		}
		return $data;
	}
	
	public function relations()
	{
		return array(
			'category'=>array(self::BELONGS_TO, 'Category', 'department_id'),
		);
	}
}
