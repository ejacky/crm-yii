<?php
class FormView
{
	private $model;

	function __construct($model = null) {
		$this->model = $model ;
	}
	
	public function password($paFieldModel)
	{
		$option =  '<tr><td width="20%"><label >' . $paFieldModel->label . '</label></td><td><input type="password" name="form[password]"/></td><td></td></tr>';
		$option .=  '<tr><td width="20%"><label style="margin-left:25px">确认密码</label></td><td><input type="password" class="rePassword" label="password"/></td><td></td></tr>';
		return $option;
	}

	public function checkbox( $paFieldModel, $exkey=null )
	{
		$name = $paFieldModel->name;
		$subOptions = '';
		if (isset($this->model->$name) && is_string($this->model->$name))
		{
			$strToArray = explode(',',$this->model->$name );
			foreach ($strToArray as $val)
			{
				$subOptions .= '<input checked="checked" name="form['.$paFieldModel->name.'][]" type="checkbox" value="'.$val.'"/>'.$val;
			}
		}else if (isset($this->model))
		{
			if (isset($this->model->$name)){
				$subOptions .= '<input name="form['.$name.'][]" type="checkbox" value="'.$this->model->id.'"/>'.$this->model->$name;
			}
			if ( isset($this->model->$exkey) ){
				$model = $this->model->$exkey;
				if ( is_array($model) ) $model=$model[0];
				$strToArray = explode(',',$model->$name );
				foreach ($strToArray as $val)
				{
					$subOptions .= '<input checked="checked" name="form['.$paFieldModel->name.'][]" type="checkbox" value="'.$val.'"/>'.$val;
				}
			}
			if (is_array($this->model)){
				foreach ($this->model as $key => $val){
					$subOptions .= '<input checked="checked" name="form['.$paFieldModel->name.'][]" type="checkbox" value="'.$val->id.'"/>'.$val->$name;
				}
			}
		}
		$option = '<tr><td width="20%"><label style="margin-left:25px">' . $paFieldModel->label . '</label></td>
		<td>'.$subOptions.'</td></tr>';
		return $option ;
	}

	public function monthPicker( $paFieldModel )
	{
		$formName = $this->isUDF($paFieldModel);
		$name = $paFieldModel->name;
		if (isset($this->model->$name))
		{
			$editName = $this->model->$name;
		}
		else
		{
			$editName = null;
		}
		$suboption = '<script src="/js/jquery/jquery.ui.datepicker.js" type="text/javascript"></script>';
		$option = '<tr><td width="20%"><label style="margin-left:25px">' . $paFieldModel->label . '</label></td>
					<td><input label="monthPicker" '.$formName.' value="'.$editName.'"/>'.$suboption.'</td></tr>';
		return $option ;
	}
	
	public function datePicker( $paFieldModel )
	{
		$formName = $this->isUDF($paFieldModel);
		$name = $paFieldModel->name;
		if (isset($this->model->$name))
		{
			$editName = $this->model->$name;
		}
		else
		{
			$editName = null;
		}
		$suboption = '<script src="/js/jquery/jquery.ui.datepicker.js" type="text/javascript"></script>';
		$option = '<tr><td width="20%"><label style="margin-left:25px">' . $paFieldModel->label . '</label></td>
					<td><input label="datePicker" '.$formName.' value="'.$editName.'"/>'.$suboption.'</td></tr>';
		return $option ;
	}

	public function radio( $paFieldModel )
	{
              	$name = $this->getName($paFieldModel);  
                if (isset($this->model->$name))
		{
			$editName = $this->model->$name;
		}
		else
		{
			$editName = null;
		}
                
		$strToArray = explode(',',$paFieldModel->attr);
		$formName = $this->isUDF($paFieldModel);
		$subOptions = '';
		foreach ($strToArray as $val){
                        if ($val == $editName)
                        {
                            $subOptions .= '<input checked="checked" '.$formName.' type="radio" value="'.$val.'"/>'.$val;
                        }
                        else
                        {
                            $subOptions .= '<input '.$formName.' type="radio" value="'.$val.'"/>'.$val;
                        }
			
		}
		$option = '<tr><td width="20%"><label style="margin-left:25px;">' . $paFieldModel->label . '</label></td>
		<td>'.$subOptions.'</td></tr>';
		return $option ;
	}

	public function provincePicker( $label )
	{
		$suboption = '<script src="/js/location.js" type="text/javascript"></script><script src="/js/YLChinaArea.js" type="text/javascript"></script>';
		$option = '<tr><td width="20%"><label style="margin-left:25px">' . $label . '</label></td>
					<td><div class="ChinaArea">
						<select id="province" style="width: 100px;"></select>
						<select id="city" style="width: 100px;"></select>
					</div></td><td><input type="hidden" name="form[hometown]" class="hometown" value="北京,北京"/></td>'.$suboption.'</tr>';
		return $option ;
	}

	public function postAttach( $name, $label )
	{
		$suboption =  <<<EOF
<link rel='stylesheet' type='text/css' href='/uploadify/uploadify.css' />
<script src="/uploadify/jquery.uploadify-3.1.js" type="text/javascript"></script>
<script>
$(function(){
	$("#file_upload_{$name}").uploadify({
		//'queueID'  : 'file_box',
		'swf'             : '/uploadify/uploadify.swf',
		'uploader'        : '/index.php/CommonInterface/UploadAttach',
		'cancelImg'		  : '/uploadify/uploadify-cancel.png',
		'onUploadSuccess' : function(file, data, response) {
			$('#file_box_{$name}').append( '<div class="uploadify-queue-item" ><div class="cancel"><a class="uploadify-queue" href="javascript:fileDelete(\''+data+'\')">X</a></div><span class="fileName">'+file.name+'</span><span class="data"> - 完成</span><input type="hidden" name="form['+data+'][id]" value="'+data+'"/><input type="hidden" name="form['+data+'][name]" value="'+file.name+'"/></div>' )
			//alert('The file ' + file.name + ' was successfully uploaded with a response of ' + response + ':' + data);
		}
	});
	$('#file_upload_{$name}').uploadify('settings','buttonText','选择文件');
	$('.uploadify-queue').live('click',function(){
		$(this).closest('.uploadify-queue-item').remove()
	});
})</script>
EOF;
		$option = '<tr><td width="20%"><label style="margin-left:25px">' . $label . '</label></td><td><input type="file" name="file_upload_'. $name .'" id="file_upload_'. $name .'" /><div class="file_box" id="file_box_'. $name .'"></div></td><td>'.$suboption.'</td></tr>';
		return $option ;
	}

	public function uploadPic( $name, $label )
	{
		$suboption = '<script src="/js/jquery/jquery.color.js" type="text/javascript"></script><script src="/js/jquery/jquery.Jcrop.js" type="text/javascript"></script><link rel="stylesheet" type="text/css" href="/css/jquery.Jcrop.css" />';
		if (isset($this->model->avatar)){
			$option = '<tr><td width="20%"><label style="margin-left:25px">' . $label . '</label></td><td class="pictrueLoad"><img src="'.$this->model->avatar.'"/></td><td><button onclick="return false" class="uploadPic '.$name.'">上传图片</button></td>'.$suboption.'</tr>';
		}else{
			$option = '<tr><td width="20%"><label style="margin-left:25px">' . $label . '</label></td><td class="pictrueLoad"></td><td><button onclick="return false" class="uploadPic '.$name.'">上传图片</button></td>'.$suboption.'</tr>';
		}
		return $option ;
	}

	public function getaddOption( $name, $label )
	{
		
		$className = get_class($this->model);
		$isMustLogo = '<span class="addOption '.$name.'">增加选项</span>';
		$attr = SingleCategory::model()->findAll('nameSpace=:name and name=:na order by sequence', array(':name'=>$className, ':na'=>$name));
		
		$subOptions = '';
		$hiddenoption = '<div  class="hidden popoption '.$name.'"><h3>'.$className.'</h3><input type="hidden" name="nameSpace" value="'. $className .'" /><input type="hidden" name="formName" value="'. $name .'" />' ;
		$hiddenoption .= '<label class="label">添加数据键值</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label class="label">'. $label .'</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label style="margin-left:25px">排序</label><br/>';
		foreach ($attr as $key=>$value)
		{
			$subOptions .= '<option value=' . $value->key . '>' . $value->value .'</option>';
			$hiddenoption .= '<input type="text" name="form[update]['.$value->id.'][key]" value="'. $value->key .'" />&nbsp;&nbsp;<input type="text" name="form[update]['.$value->id.'][value]" value="'. $value->value .'" />&nbsp;&nbsp;<input type="text" name="form[update]['.$value->id.'][sequence]" value="'.$value->sequence.'" /><input class="deleteOption '. $value->id .'" type="button" value="删除" /><br/>';
		}
		$option = '<tr><td width="20%"><label style="margin-left:25px">' . $label . '</label></td><td><select class="'.$className.$name.'" name="form[s'. $name .']">' . $subOptions .'</select>'. $isMustLogo.'</td></tr>';
		$hiddenoption .= '<span class="tipOption '.$name.'"></span><input class="addOptionButton" type="button" value="添加选项" /><input class="submitOption" type="button" value="提交" /></div>' ;
		$option = $option.$hiddenoption;
		return $option ;
	}

	public function getLabel($paFieldModel)
	{
		$name = $this->getName($paFieldModel);
                $explain = $this->getExplain($paFieldModel);
		$isMustLogo = $this->checkMust($paFieldModel->isMust,$paFieldModel->name, $paFieldModel->label);
		if (isset($this->model->$name))
		{
			$editName = $this->model->$name;
		}
		else
		{
			$editName = null;
		}
		if ($paFieldModel->category != 'basic')
		{
			$option = '<tr><td color="yellow" width="20%" class="label-name"><label style="margin-left:25px">'. $paFieldModel->label .'</label></td><td><input label="'.$name.'" type=' . $paFieldModel->type . ' name=form[udf_'. $name . '] value='. $editName .'></input>'. $isMustLogo.'</td></tr>';
		}
                else
		{
			$option = '
                            <tr><td width="20%" class="label-name"><label style="margin-left:25px">' . $paFieldModel->label .'</label><span style="color:red" class="span2-'. $name .'"></span></td><td><input label="'.$name.'" type= ' . $paFieldModel->type .' name=form[' . $name .'] value="'. $editName.'">'. $isMustLogo.'</td><td><span class="span-'. $name .'"></span></td></tr>
                            <tr><td width="20%"></td><td><span style="color:grey">'. $explain .'</span></td></tr>';
		}
		return $option ;
	}
        

	public function getText( $paFieldModel )
	{
		$name = $this->getName($paFieldModel);
                $explain = $this->getExplain($paFieldModel);
		$isMustLogo = $this->checkMust($paFieldModel->isMust,$paFieldModel->name, $paFieldModel->label);
		if (isset($this->model->$name))
		{
			$editName = $this->model->$name;
		}
		else
		{
			$editName = null;
		}
		if ($paFieldModel->category != 'basic')
		{
			$option = '<tr><td color="yellow" width="20%" class="label-name"><label style="margin-left:25px">'. $paFieldModel->label .'</label></td><td><input label="'.$name.'" type=' . $paFieldModel->type . ' name=form[udf_'. $name . '] value='. $editName .'></input>'. $isMustLogo.'</td></tr>';
		}else
		{
			$option = '
                            <tr><td width="20%" class="label-name"><label style="margin-left:25px">' . $paFieldModel->label .'</label><span style="color:red" class="span2-'. $name .'"></span></td><td><input label="'.$name.'" type= ' . $paFieldModel->type .' name=form[' . $name .'] value="'. $editName.'">'. $isMustLogo.'</td><td><span class="span-'. $name .'"></span></td></tr>
                            <tr><td width="20%"></td><td><span style="color:grey;font-size: 1em">'. $explain .'</span></td></tr>';
		}
		return $option ;
	}

	public function getSelect($paFieldModel)
	{
		$name = $paFieldModel->name;
		$isMustLogo = $this->checkMust($paFieldModel->isMust,$paFieldModel->name, $paFieldModel->label);
		$str = str_replace(',',',',$paFieldModel->attr);
		$str = str_replace('，',',',$str);
		$str = str_replace('/n',',',$str);
		$str = str_replace(' ',',', $str);
		$strToArray = explode(',',$str);
		$subOptions = '';
		foreach ($strToArray as $arrayName => $value)
		{
			if (isset($this->model->$name) && $this->model->$name == $value)
			{
				$subOptions .= '<option value=' . $value . ' selected="selected">' . $value .'</option>';
			}
			else
			{
				$subOptions .= '<option value=' . $value . '>' . $value .'</option>';
			}
		}
		if ($name == 'category')
		{
                        $criteria = new CDbCriteria();
                        
			$fieldGroupModel = FormHandler::getAllDataObject('SingleCategory');
			foreach ($fieldGroupModel as $subFieldGroupModel)
			{
				$subOptions = '<option value="'. $subFieldGroupModel->value .'" >'. $subFieldGroupModel->value .'</option>' . $subOptions;
			}
		}
                if ($name == 'project_id')
                {
                        $courseModel = FormHandler::getAllDataObject('TrainCourse');
                        foreach ($courseModel as $subCourseModel)
                        {
                                $subOptions = '<option value="' . $subCourseModel->id .'">' . $subCourseModel->courseName . '</option>' . $subOptions;
                        }
                }
		if ($name == 'staff_id' || $name == 'salesId' || $name == 'followCourseId' || $name == 'createId')
		{
			$staffModel = FormHandler::getAllDataObject('Staff');
			foreach ($staffModel as $subStaffModel)
			{
				$subOptions = '<option value="'. $subStaffModel->id.'">'. $subStaffModel->username .'</option>' . $subOptions;
			}
		}
                if ($name == 'client_id')
		{
			$staffModel = FormHandler::getAllDataObject('Company');
			foreach ($staffModel as $subStaffModel)
			{
				$subOptions = '<option value="'. $subStaffModel->id.'">'. $subStaffModel->name .'</option>' . $subOptions;
			}
		}
                if ($name == 'contactId' || $name == 'contact_id')
		{
			$staffModel = FormHandler::getAllDataObject('Contact');
			foreach ($staffModel as $subStaffModel)
			{
				$subOptions = '<option value="'. $subStaffModel->id.'">'. $subStaffModel->name .'</option>' . $subOptions;
			}
		}
		if ($name == 'company_id')
		{
			$companyModel = FormHandler::getAllDataObject('Company');

			foreach ($companyModel as $subCompanyModel)
			{
				$subOptions = '<option value="'. $subCompanyModel->id.'">'. $subCompanyModel->name .'</option>' . $subOptions;
			}
		}
		if ($name == 'lecturer_id' || $name == 'lecturerId')
		{
			$trainLecturerModel = FormHandler::getAllDataObject('TrainLecturer');

			foreach ($trainLecturerModel as $subTrainLecturerModel)
			{
				$subOptions = '<option value="'. $subTrainLecturerModel->id.'">'. $subTrainLecturerModel->lecturerName .'</option>' . $subOptions;
			}
		}
		if ($name == 'questionnaire_id')
		{
			$trainQuestionnaireModel = FormHandler::getAllDataObject('TrainQuestionnaire');

			foreach ($trainQuestionnaireModel as $subTrainQuestionnaireModel)
			{
				$subOptions = '<option value="'. $subTrainQuestionnaireModel->id.'">'. $subTrainQuestionnaireModel->question .'</option>' . $subOptions;
			}
		}
			
		if ($paFieldModel->category != 'basic')
		{
			if ($name == 'isMust')
			{
				$option = '<tr><td width="20%"><label style="margin-left:25px">' . $paFieldModel->label . '</label></td><td><select multiple="multiple" name="form[udf_'. $name .'][]">' . $subOptions .'</select>'. $isMustLogo.'</td></tr>';
			}
			else
			{
				$option = '<tr><td width="20%"><label style="margin-left:25px">' . $paFieldModel->label . '</label></td><td><select name="form[udf_'. $name .']">' . $subOptions .'</select>'. $isMustLogo.'<span class="span2-'. $name .'"></span></td></tr>';
			}
		}
		else
		{
			if ($name == 'isMust' || $name == 'followCourseId')
			{
				$option = '<tr><td width="20%"><label style="margin-left:25px">' . $paFieldModel->label . '</label></td><td><select multiple="multiple" name="form['. $name .'][]">' . $subOptions .'</select>'. $isMustLogo.'</td></tr>';
			}
			else
			{
				$option = '<tr><td width="20%"><label style="margin-left:25px">' . $paFieldModel->label . '</label></td><td><select style="width:110px;" class="chzn-select" name="form['. $name .']">' . $subOptions .'</select>'. $isMustLogo.'<span class="span2-'. $name .'"></span></td></tr>';
			}
		}
		return $option ;
	}

	public function getTextarea($paFieldModel)
	{
		$name = $paFieldModel->name;
		if (isset($this->model->$name))
		{
			$editName = $this->model->$name;
		}else
		{
			$editName = '';
		}
		$name = $paFieldModel->name;
		$isMustLogo = $this->checkMust($paFieldModel->isMust,$paFieldModel->name, $paFieldModel->label);
		if ($paFieldModel->category != 'basic')
		{
			$option = '<tr><td width="20%"><label style="margin-left:25px">' . $paFieldModel->label . '</label></td><td><textarea name="form[udf_'. $name . ']">'.$editName.'</textarea>'. $isMustLogo.'</td></tr>';
		}
		else
		{
			$option = '<tr><td width="20%"><label style="margin-left:25px">' . $paFieldModel->label . '</label></td><td><textarea name="form['. $name . ']">'.$editName.'</textarea>'. $isMustLogo.'<span class="span2-'. $name .'"></span></td></tr>';
		}
		return $option ;
	}

	public function getexSelect( $paFieldModel, $exSelectObj=null, $stage='single' )
	{
		$name = $paFieldModel->name;
		$isMustLogo = $this->checkMust($paFieldModel->isMust,$paFieldModel->name, $paFieldModel->label);
		$subOptions = $subOptions  = '';
		if ($stage!='single'){
			$subOptions .= '<option value=""></option>';
			foreach ($exSelectObj as $value)
			{
				if (isset($this->model->$name) && $this->model->$name == $value->name)
				{
					$subOptions .= '<option selected="selected" value="'. $value->id .'">'.str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $value->level - 1).$value->name .'</option>' ;
				}else{
					$subOptions .= '<option value="'. $value->id .'">'.str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $value->level - 1).$value->name .'</option>' ;
				}
			}
		}else{
			foreach ($exSelectObj as $value)
			{
				if (isset($this->model->$name) && $this->model->$name == $value->name)
				{
					$subOptions .= '<option value=' . $value->id . ' selected="selected">' . $value->label .'</option>';
				}else{
					$subOptions .= '<option value=' . $value->id . '>'.$value->label.'</option>';
				}
			}
		}
		$option = '<tr><td width="20%"><label style="margin-left:25px">' . $paFieldModel->label . '</label></td><td><select name="form['. $name .']">' . $subOptions .'</select>'. $isMustLogo.'</td></tr>';
		return $option ;
	}

	private function checkMust($isMust, $name, $label)
	{
		$isMustArray = explode(',', $isMust);
		$isMustLogo = '';
		if (in_array('必填',$isMustArray))
		{
			$isMustLogo = '<script>
				$(function () {
					$(\'.span2-'. $name  .'\').text(\'*\');
				        $("input[name=\'form['. $name .']\']").blur(function () {
					     value = $(this).val(); 
					     if (value != \'\' ) {
						     $(\'.span-'. $name .'\').text(\'\');    
					     }
				 });
				});</script>' . $isMustLogo;	 
		}

		if (in_array('电话',$isMustArray))
		{
			$isMustLogo = '<script>
				$(function () {
					$("input[name=\'form['. $name .']\']").keypress(function (event) {
						Code = (event.keyCode)?event.keyCode:event.charCode;
						if(Code != 8){
							if(!$.browser.mozilla)
						   {
								if(Code < 48 || Code > 57) {event.preventDefault();$(\'.span-'. $name .'\').text(\'请输入数字！\').css("color","red");}
						   }
						   else
						   {
							  if(Code < 48 || Code > 57){event.preventDefault();$(\'.span-'. $name .'\').text(\'请输入数字！\').css("color","red");}
						   }
					   }
				   });
				   
				$("input[name=\'form['. $name .']\']").blur(function () {
					 phone = $(this).val(); 
					 if (phone != \'\' && (phone.length > 11 || phone.length < 6)) {
						 $(\'.span-'. $name .'\').text(\''. $label .'位数需在 6 到 11 之间\').css("color","red");
                                         
					 }
                                         else
                                         {
                                                 $(\'.span-'. $name .'\').text(\'\');
                                         }
				 });
			});
				</script>' . $isMustLogo;
		}

		return $isMustLogo;
	}

	private function isUDF($paFieldModel){
		return ($paFieldModel->category=='basic') ? 'name="form['.$paFieldModel->name.']"' : 'name="form[udf_'.$paFieldModel->name.']"' ;
	}

	private function getName($paFieldModel){
		return empty($paFieldModel->defaultValue) ? $paFieldModel->name : $paFieldModel->defaultValue;
	}
        
        private function getExplain($paFieldModel) 
        {
            return !empty($paFieldModel->explain)?$paFieldModel->explain : null; 
        }

	private function getKey($paFieldModel){
		return empty($paFieldModel->defaultValue) ? $paFieldModel->name : $paFieldModel->defaultValue;
	}
}