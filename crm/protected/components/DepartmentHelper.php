<?php

class DepartmentHelper
{
	public static function getDepartmentsForSelect()
	{
		$allDepartment = DepartmentModel::model()->findAll();
		$departmentArray = array();
		$departmentArray[] = '无上级部门';
		foreach ($allDepartment as $dapartment)
		{
			$departmentArray[$dapartment->id] = $dapartment->displayName;
		}
		
		return $departmentArray;
	}
	
	public static function getPositionForCheckbox()
	{
		$allPosition = PositionModel::model()->findAll();
		$positionArray = array();
		foreach ($allPosition as $position)
		{
			$positionArray[$position->name] = $position->displayName;
		}
		
		return $positionArray;
	}
}
