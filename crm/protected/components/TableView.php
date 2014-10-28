<?php
class TableView {    
	public static function fetchPaFormColumns($model) {
		foreach ($model->findAll() as $sub) {
			$fieldAttributes = $sub->attributes;
		}

		foreach ($fieldAttributes as $name => $value) {
			if ($name == 'id') {
				$columns[] = array(
					'class' => 'CLinkColumn',
					'header' => '系统名称',
					'labelExpression' => '$data->name',
					'urlExpression' => 'Yii::app()->createUrl("customForm/fieldIndex",array("formId"=>$data->id))',
				);
			} else if($name != 'name')
		    {
				$columns[] = $name;
		   	}
		}

		$columns[] = array(
			'class' => 'CButtonColumn',
			'header' => '操作',
			'template' => '{update} {delete}',
			'updateButtonUrl' => 'Yii::app()->createUrl("customForm/editForm",array("formId"=>$data->id))',
			'deleteButtonUrl' => 'Yii::app()->createUrl("customForm/deleteForm",array("formId"=>$data->id))',
			'deleteButtonLabel' => '删除',
			'updateButtonLabel' => '编辑',
		);

		return $columns;
	}

	public static function fetchPaFieldColumns($model) {
		$titles = array('name', 'formName', 'orderId', 'defaultValue', 'type', 'form_id', 'attr', 'category', 'label', 'isMust', 'explain');

		$row = $model->with('formType')->find();
		if (!$row)
		{
			return $titles;
		}

		$columns['link'] = array(
			'class' => 'CLinkColumn',
			'header' => Tools::getTableTitle('name'),
			'labelExpression' => '$data->label',
			'urlExpression' => 'Yii::app()->createUrl("customForm/editField", array("fieldId"=>$data->id))',
		);
		
		foreach ($row->attributes as $name => $value) {
			if ($name == 'name')
			{
				continue;
			}
			else if ($name == 'type')
			{
				$columns[$name] = array(
					'name' => $name,
					'value' => '$data->formType->value',//$data->formType->id
				);
			}
                        else if ($name == 'form_id')
                        {
                            $columns[$name] = array(
                                'name' => $name,
                                'value' => '$data->form->name',
                            );
                            
                        }
			else if (in_array($name, $titles)) {
				$columns[$name] = $name;
			}
		}

		$columns[] = array(
			'class' => 'CLinkColumn',
			'header' => '操作',
			'label' => '删除',
			'urlExpression' => 'Yii::app()->createUrl("customForm/deleteField",array("fieldId"=>$data->id,"formId"=>$data->form->id))',
		);

		return $columns;
	}

	public static function fetchTrainCourseColumns($model) {
		foreach ($model as $sub) {
			$fieldAttributes = $sub->attributes;
		}

		foreach ($fieldAttributes as $name => $value) {
			if ($name == 'id') {
				$columns[] = array(
					'class' => 'CLinkColumn',
					'header' => '名称',
					'labelExpression' => '$data->courseName',
					'urlExpression' => 'Yii::app()->createUrl("course/courseBrowse",array("courseId"=>$data->id))',
				);
			} else if ($name == 'contact_id') {
                                $columns[] = array(
                                    'name' => '联系人',
                                    'value' => '$data->contact->name',
                                );     
                        } else if ($name == 'followCourseId') {
                                $columns[] = array(
                                    'name' => '跟客人',
                                    'type' => 'raw',
                                    'value' => '$data->fetchFollowPersonInfo()'
                                );                  
                        }
                        
                        else {
				if ($name != 'lecturer_id') {
					$columns[] = $name;
				}
			}
		}
		/*
		  $columns[] = array(
		  'class' => 'CLinkColumn',
		  'header' => '讲师',
		  'label' => '添加讲师',
		  'urlExpression' => 'Yii::app()->createUrl("course/addLecturer",array("addLecturer"=>$data->id))',
		  );
		 * 
		 */
		$columns[] = array(
			'name' => '讲师',
			'value' => '$data->lecturer->lecturerName',
		);

		$columns[] = array(
			'class' => 'CButtonColumn',
			'header' => '操作',
			'template' => '{update} {delete}',
			'updateButtonUrl' => 'Yii::app()->createUrl("course/editCourse", array("courseId"=>$data->id))',
			'deleteButtonUrl' => 'Yii::app()->createUrl("course/deleteCourse", array("courseId"=>$data->id))',
			'deleteButtonLabel' => '删除',
			'updateButtonLabel' => '编辑',
		);

		return $columns;
	}

	public static function fetchFileColumns($model) {
		$titles = array('checkbox', 'fileName_re', 'time', 'userName_re', 'attachment.size', 'operater');

		$row = $model->find();
		if (!$row)
		{
			return $titles;
		}

		$columns['checkbox'] = array(
            'class' => 'CCheckBoxColumn',
            'header' => '<input type="checkbox" id="checkall"/>',
			'selectableRows'=>3,
        );
		
		foreach ($row->attributes as $name => $value) {
			if (in_array($name, $titles)) {
				$columns[$name] = $name;
			}
		}

		$columns['attachment.size'] = array(
			'name' => 'attachment.size',
			'value' => 'Tools::sizecount($data->attachment->size)'
		);
		
		$columns['operater'] = array(
			'header' => '操作',
			'class' => 'CButtonColumn',
        	'template'=>'{download} {delete}',
	        'deleteButtonLabel'=>'删除',
	        'downloadButtonLabel'=>'下载',
		);

		return $columns;
	}

	public static function fetchTraineeColumns($model) {
		foreach ($model as $sub) {
			$fieldAttributes = $sub->attributes;
		}

		foreach ($fieldAttributes as $name => $value) {
			if ($name == 'traineeName') {
				$columns[] = array(
					'class' => 'CLinkColumn',
					'header' => '名称',
					'labelExpression' => '$data->traineeName',
					'urlExpression' => 'Yii::app()->createUrl("account/courseBrowse",array("courseId"=>$data->id))',
				);
			} else {
				if ($name != 'questionnaire_id') {
					$columns[] = $name;
				}
			}
		}
		/*
		  $columns[] = array(
		  'name' => '问卷',
		  'value' => '$data->questionnaire->question'
		  );
		 */

		$columns[] = array(
			'class' => 'CButtonColumn',
			'header' => '操作',
			'template' => '{update}  {delete}',
			'updateButtonUrl' => 'Yii::app()->createUrl("course/editTrainee",array("traineeId"=>$data->id))',
			'deleteButtonUrl' => 'Yii::app()->createUrl("course/deleteTrainee",array("traineeId"=>$data->id))',
			'updateButtonLabel' => '编辑',
			'deleteButtonLabel' => '删除',
		);
		/*
		  $columns[] = array(
		  'class' => 'CLinkColumn',
		  'header' => '问卷',
		  'label' => '添加问卷',
		  'urlExpression' => 'Yii::app()->createUrl("course/addQuestionnaire",array("addLecturer"=>$data->id))',
		  );
		 * 
		 */
		return $columns;
	}

	public static function fetchLecturerColumns($model) {
		foreach ($model->findAll() as $sub) {
			$fieldAttributes = $sub->attributes;
		}

		foreach ($fieldAttributes as $name => $value) {
			if($name !='id'){
			$columns[] = $name;
		}
		}

		$columns[] = array(
			'class' => 'CButtonColumn',
			'header' => '操作',
			'template' => '{update} {delete}',
			'updateButtonUrl' => 'Yii::app()->createUrl("course/editLecturer",array("lecturerId"=>$data->id))',
			'deleteButtonUrl' => 'Yii::app()->createUrl("course/deleteLecturer",array("lecturerId"=>$data->id))',
			'updateButtonLabel' => '编辑',
			'deleteButtonLabel' => '删除',
		);

		return $columns;
	}

	public static function fetchQuestionnaireColumns() {
		return array(
			'id',
			'question',
			'answer',
			array(
				'class' => 'CButtonColumn',
				'header' => '操作',
				'template' => '{update} {delete}',
				'updateButtonUrl' => 'Yii::app()->createUrl("course/editQuestionnaire",array("quesId"=>$data->id))',
				'deleteButtonUrl' => 'Yii::app()->createUrl("course/deleteQuestionnaire",array("quesId"=>$data->id))',
				'updateButtonLabel' => '编辑',
				'deleteButtonLabel' => '删除',
			),
		);
	}

	public static function fetchClientColumns($model) {
		$columns = array();
//        $notInColumns = self::fetchDisplayColumns('company-grid');
		foreach ($model->findAll() as $subModel) {
			$fieldAttributes = $subModel->attributes;
		}
		foreach ($fieldAttributes as $name => $value) {
//            if ($name == 'name' && in_array($name, $notInColumns)) 
			if ($name == 'id') {
				$columns[] = array(
					'name' => 'name',
					'type' => 'raw',
					'value' => 'CHtml::link($data->name,array("client/clientBrowse","clientId" => $data->id))',
				);
			}
			//           else if ($name != 'name' && in_array($name, $notInColumns))
			else if ($name != 'name')
			 {
				$columns[] = $name;
			}
		}
		$columns[] = array(
			'class' => 'CLinkColumn',
			'header' => '联系记录',
			'label' => '录入',
			'urlExpression' => 'Yii::app()->getController()->createUrl("addTask",array("clientId"=>$data->id))',
			'visible' => true,
				
		);
		$columns[] = array(
			'name' => 'contactPerson',
			'type' => 'raw',
			'value' => '$data->fetchContactInfo()',
		);

		return $columns;
	}

	public static function fetchContactColumns($model) {
		$columns = array();
//        $notInColumns = self::fetchDisplayColumns('contact-grid');
		foreach ($model->findAll() as $subModel) {
			$fieldAttributes = $subModel->attributes;
		}

		foreach ($fieldAttributes as $name => $value) {
			$notInColumns = $name;
			//           if ($name == 'name' && in_array($name, $notInColumns))
			if ($name == 'id') {
				$columns[] = array(
					'name' => 'name',
					'type' => 'raw',
					'value' => 'CHtml::link($data->name, array("contact/contactBrowse", "contactId" => $data->id))'
				);
			}
//            else if ($name != 'name' && in_array($name, $notInColumns))
			else if ($name != 'name' && $name != 'company_id') {
				$columns[] = $name;
			}
		}
		$columns[] = array(
			'name' => 'staffPerson',
			'value' => '$data->staff->username',
			'filter' => new Contact,
		);
		$columns[] = array(
			'name' => 'clientName',
			'value' => '$data->company->name',
		);
		$columns[] = array(
			'class' => 'CButtonColumn',
			'header' => '操作',
			'template' => '{update} {delete}',
			'updateButtonUrl' => 'Yii::app()->createUrl("contact/editContact", array("contactId" => "$data->id"))',
			'deleteButtonUrl' => 'Yii::app()->createUrl("contact/deleteContact", array("contactId" => "$data->id"))',
			'updateButtonLabel' => '编辑',
			'deleteButtonLabel' => '删除',
		);
		$columns[] = array(
			'class' => 'CLinkColumn',
			'header' => '联系记录',
			'label' => '录入',
			'urlExpression' => 'Yii::app()->createUrl("contact/addTask",array("contactId" => $data->id))',
		);

		return $columns;
	}

	public static function fetchDisplayColumns($gridName) {
		$criteria = new CDbCriteria();
		$criteria->condition = 'tableName = :tableName and staff_id = :staffId';
		$criteria->params = array(':tableName' => $gridName, ':staffId' => Yii::app()->user->id);

		$model = FormTable::model()->find($criteria);
		$selected = $model->selectedField;
		$selectedArray = explode(',', $selected);

		return $selectedArray;
	}
	
	public static function fetchTableColumns($model)
	{
		foreach ($model->findAll() as $sub) {
			$fieldAttributes = $sub->attributes;
		}
		foreach ($fieldAttributes as $name => $value) {
			if ($name == 'id') {
				$columns[] = array(
					'class' => 'CLinkColumn',
					'header' => '表格名称',
					'labelExpression' => '$data->tablename',
					'urlExpression' => 'Yii::app()->createUrl("tableSet/tableIndex",array("tableId"=>$data->id))',
				);
			}
		}	
			return $columns;
	}

}
