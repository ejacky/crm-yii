<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PrivilegeApi
 *
 * @author Marvin
 */
class CMSPrivilegeApi
{
	/**
	 *
	 * @param type $className
	 * @return CMSPrivilegeApi 
	 */
	public static function init($className = __CLASS__)
	{
		return new $className;
	}
	
	public function have($task, $department = '', $position = '')
	{
		// always have privilege for administrator
		if (Yii::app()->user->id == 1)
		{
			return true;
		}
		
		$tasks = UserTask::model()->getUserTasks();
		
		return in_array($task, $tasks);
	}
}

?>
