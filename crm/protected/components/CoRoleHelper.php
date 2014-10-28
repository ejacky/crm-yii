<?php

class CoRoleHelper
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
	
	public static function getTaskForCheckbox()
	{
		$allTask= CoTaskModel::model()->findAll();
		$taskArray = array();
		foreach ($allTask as $task)
		{
			$taskArray[$task->name] = $task->displayName;
		}
		
		return $taskArray;
	}
}
