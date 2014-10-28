<?php

/**
 *
 * custom form 处理系统
 * @author Administrator
 *
 */

class FormHandler
{
	/**
	 *
	 * @param string $table 查询数据库model
	 * @param unknown_type $condition
	 */
    
	public static function getAllDataObject($table, $condition='')
	{
		$tableModel = new $table ;
		$allForm = $tableModel->model()->findAll($condition);
		return $allForm;
	}

	public static function saveFuCrmTable($tableInfo)
	{
		$tableModel = new FormTable();
		$editTableModel = $tableModel->find('staff_id = :staffId and tableName = :tableName', array(':staffId' => Yii::app()->user->id, ':tableName' => $tableInfo['tableName']));
		if ($editTableModel)
		{
			$isSave = $editTableModel->saveTable($tableInfo);
		}else
		{
			$isSave = $tableModel->saveTable($tableInfo);
		}
		return $isSave;
	}

	public static function fetchColumns($field = null, $tbl=null, $unInColumns=null)
	{
		if ($field['tableName'] != null){
			$notInColumns = self::fetchDisplayColumns($field);
		}else{
			$notInColumns = $field;
		}
		$form = PaField::model()->findAllByAttributes(array('nameSpace' => $tbl));
		$getBasicInfo = array();
		foreach ($form as $subForm)
		{
			if ($subForm->category == 'basic')
			{
				if ( is_array($unInColumns) && in_array($subForm->name, $unInColumns )){
					continue ;
				}else{
					$getBasicInfo[] = $subForm->name;
				}
			}else{
				
				if ($notInColumns && in_array($subForm->name, $notInColumns)){
					
					$getBasicInfo[] = array(
	                    'name' => $subForm->name,
					    'value' => 'isset($data->task[0]) ? $data->task[0]->taskSystemName : "" ',
					);
				}
			}
		}
		$getBasicInfo[] = array(
                    'class' => 'CButtonColumn',
		            'header' => '操作',
		        	'template'=>'{update} {delete}',
        			'updateButtonUrl'=>'Yii::app()->createUrl("'.$field['controller'].'/update'.$field['action'].'",array("'.$field['action'].'"=>$data->id))',
        			'deleteButtonUrl'=>'Yii::app()->createUrl("'.$field['controller'].'/delete'.$field['action'].'",array("'.$field['action'].'"=>$data->id))',
			        'deleteButtonLabel'=>'删除',
			        'updateButtonLabel'=>'编辑',
		);
		return $getBasicInfo;
	}

	private static  function fetchDisplayColumns($searchInfo)
	{
		$criteria = new CDbCriteria();
		$criteria->condition = 'tableName = :tableName and staff_id = :staffId';
		$criteria->params = array(':tableName' => $searchInfo['tableName'], ':staffId' => Yii::app()->user->id);
		$model = FormTable::model()->find($criteria);
		$selectedArray = null;
		if ($model){
			$selected = $model->selectedField;
			$selectedArray = explode(',', $selected);
		}
		return $selectedArray;
	}

	public static function saveFormInfo($model, $formInfo)
	{
		if (isset($formInfo['username']))
		{
			$model->username = $formInfo['username'];
		}
		//$model->date = date('Y-m-d H:m:s');
		//$type = ($isNewRecord=1) ? 'create':'edit';
		$type = 'create';
		$isSave = $model->save();
		$arr = array();
		foreach ($formInfo as $name => $value)
		{
			$str = explode('_',$name);
			if ($str[0] == 'udf')
			{
				$arr[$name] = $value;
			}
		}
		$udfModel = new Udf();
		if ($type == 'create')
		{
			self::saveUdf($arr, $model->id, 'staff');
		}
		else if ($type == 'edit')
		{
			self::editUdf($arr, $model->id, 'staff');
		}
		//$companyLog = new CompanyLog();
		//$companyLog->saveCompanyLog($formInfo, $arr, $this->id,$type);
		return $isSave;
	}

	public static function saveUdf($info, $formPrimaryIndex, $distinguishForm)
	{
		foreach ($info as $name => $value)
		{
			$udfModel = new Udf();
			$udfModel->saveUdf($name, $value, $formPrimaryIndex, $distinguishForm);
		}
	}
}