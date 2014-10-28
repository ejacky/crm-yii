<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CMSBaseModel
 *
 * @author Marvin
 */
class CMSBaseModel extends CActiveRecord {
	
	public function findAllReturnAttributeArray($condition='',$params=array(),$attribute='id')
	{
		$datas = $this->findAll($condition, $params);

		$return = array();
		foreach ($datas as $data)
		{
			$return[] = $data->$attribute;
		}
		return $return;
		
	}
}

?>
