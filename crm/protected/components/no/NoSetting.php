<?php

/**
 *
 * @author sam sam@ozzyad.com
 *
 */
class  NoSetting
{
	private static $instance;
	public static function getInstance($newInstance = false)
	{
		if($newInstance || self::$instance == null) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function getAllSetting($module)
	{
		return SingleCategory::model()->findAllByAttributes(array('nameSpace'=>$module));
	}

	public function getOneSetting($module, $type)
	{
		return SingleCategory::model()->findByAttributes(array('nameSpace'=>$module,'key'=>$type))->value;
	}
}