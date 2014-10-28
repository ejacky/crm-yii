<?php

/**
 *
 * 说明文档    document\FormExplain\自定义表单使用文档.xlsx
 * @author Administrator
 *
 */

// Maybe we can need two parameters to __construct 
//$model and formField that we can reduce some code .
class FetchSingleInputHtml
{
	private $model ;
	private $id = null ;
        private $controller;
        
        //
        private $name;
        private $label;
        
        
      //  private $formField;
        /*
         * for backup
        private $action;
        private $controller;
        private $module;
         * 
         */

	function __construct($model = null)
	{
            /* for backup
                $this->module = Yii::app()->homeUrl;
                $this->controller = Yii::app()->controller->id;
                $this->action = Yii::app()->controller->action->id;
             * 
             */
		$this->model = $model ;
                $this->controller = Yii::app()->controller->id;
                $this->action = Yii::app()->controller->action->id;
                //$this->model = $this->fetchModelByController($this->controller, $this->action);              
	}
        
        private function fetchModelByController($controller, $action)
        {
                $tempModel = null;
                switch ($controller)
                {
                        case $controller == 'client': {$tempModel = new Company;}
                        case $controller == 'contact': {$tempModel = new Contact;}
                        case $controller == 'assis' : {$tempModel = null;}
                        case $controller == 'customForm' : 
                        {
                                if (strpos($action, 'field'))
                                {
                                        $tempModel = new PaField;
                                }
                                if (strpos($action, 'form'))
                                {
                                        $tempModel = new PaForm;
                                }
                        }
                }
                return $tempModel;
            
        }
        
        public function emptyLabel()
        {
                return '';
        }
        
         public function label($formfield)
        {
                $name = $this->getCoverage($formfield, 'name');
		$label = $this->getCoverage($formfield, 'label');
		$attr = $this->getCoverage($formfield, 'attr');
                $option = '<tr><td class=" ' . $name. ' ">' . $label . '</td><td>' .$name . '</td><input type="text" value="' . $attr .'"><input type="hidden" name="' . $name . '"></tr>';
                
                return 'aa';
        }

	public function text($formfield)
	{
		$name = $this->getCoverage($formfield, 'name');
		$label = $this->getCoverage($formfield, 'label');
		$formName = $this->isUDF($formfield);
		$fillValue = $this->getFillValue($name, $this->getCoverage($formfield,'defaultValue'));

		$type = $this->getCoverage($formfield, 'textType');
		$type = $type ? $type : 'text' ;
		$isMustLogo = $this->checkMust($this->getCoverage($formfield, 'isMust'),$name, $label);
		$rules = $this->addRules($this->getCoverage($formfield, 'rules'),$formName);
		$option = ' <tr><td width="20%" class="label-name"><label>'.$label.'</label><span style="color:red" class="span2-'.$name.'"></span></td>
					<td><input class="'.$name.'" label="'.$name.'" type="'.$type.'" '.$formName.' value="'.$fillValue.'">'.$isMustLogo.$rules.'</td>
					<td><span class="span-'.$name.'"></span></td></tr>
					<tr><td width="20%"></td><td><span style="color:grey;font-size: 1em">'.$this->getCoverage($formfield, 'explain').'</span></td></tr>';
                
		return $option ;
	}

	public function textarea($formfield)
	{
		$name = $this->getCoverage($formfield,'name');
		$label = $this->getCoverage($formfield,'label');
		$formName = $this->isUDF($formfield);
		$fillValue = $this->getFillValue($name, $this->getCoverage($formfield,'defaultValue'));

		$isMustLogo = $this->checkMust($this->getCoverage($formfield,'isMust'), $name, $label);
		$option = '<tr><td width="20%"><label>' .$label. '</label><span style="color:red" class="span2-'.$name.'"></span></td><td><textarea '.$formName.'>'.$fillValue.
				'</textarea>'. $isMustLogo. '</td></tr>
				<tr><td width="20%"></td><td><span style="color:grey;font-size: 1em">'.$this->getCoverage($formfield, 'explain').'</span></td></tr>';
		return $option ;
	}

	public function SingleInnerSelect($formfield)
	{
		$name = $this->getCoverage($formfield,'name');
		$label = $this->getCoverage($formfield,'label');
		$formName = $this->isUDF($formfield);
		$fillValue = $this->getFillValue($name, $this->getCoverage($formfield,'defaultValue'));

		$strToArray = explode(',',$this->getCoverage($formfield,'attr'));
		$subOptions = '';
		foreach ($strToArray as $value)
		{
			$checked = ($value == $fillValue) ? 'selected="selected"'  : '' ;
			$subOptions .= '<option value='.$value.' '.$checked.'>'.$value.'</option>';
		}
		$option = '<tr><td width="20%"><label>' .$label. '</label></td><td><select '.$formName.'>'.$subOptions.'</select></td></tr>';
		return $option ;
	}

	public function SingleOutsideSelect($formfield)
	{
		$name = $this->getCoverage($formfield, 'name');
		$label = $this->getCoverage($formfield,'label');
		$formName = $this->isUDF($formfield);
		$fillValue = $this->getFillValue($name, $this->getCoverage($formfield,'defaultValue'));

		$key = $this->getCoverage($formfield, 'key');
		$objName = $this->getCoverage($formfield, 'tableModelName');
		$obj = new $objName();
		$exSelectObj = $obj->findAll();
		$subOptions = '';
		foreach ($exSelectObj as $value)
		{
			$select = ($value->id == $fillValue) ? 'selected="selected"' : '' ;
			$subOptions .= '<option value=' . $value->id . ' '.$select.'>' .$value->$key.'</option>';
		}
		$option = '<tr><td width="20%"><label>' .$label. '</label></td><td><select '.$formName.'>' .$subOptions.'</select></td></tr>';
		return $option ;
	}

	public function SingleAndCanAddOptionSelect($formfield, $name=null, $label=null)
	{
		if ($formfield){
			$name = $this->getCoverage($formfield,'name');
			$label = $this->getCoverage($formfield,'label');
		}
		$formName = $this->isUDF($formfield);
		$className = get_class($this->model); //$className = $this->getCoverage($formfield,'tableModelName'); 可以修改成动态条件
		$isMustLogo = '<span class="addOption '.$name.'"> <input type="button" value="增加选项"></span>';
		$attr = SingleCategory::model()->findAll('nameSpace=:name and name=:na order by sequence', array(':name'=>$className, ':na'=>$name));
		$subOptions = '';
		$hiddenoption = '<div  class="hidden popoption '.$name.'"><h3>'.$className.'</h3><input type="hidden" name="nameSpace" value="'. $className .'" /><input type="hidden" name="formName" value="'. $name .'" />' ;
		$hiddenoption .= '<label>添加数据键值</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label class="label">'. $label .'</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>排序</label><br/>';
		foreach ($attr as $value)
		{
			$subOptions .= '<option value=' . $value->key . '>' . $value->value .'</option>';
			$hiddenoption .= '<input type="text" name="form[update]['.$value->id.'][key]" value="'. $value->key .'" />&nbsp;&nbsp;<input type="text" name="form[update]['.$value->id.'][value]" value="'. $value->value .'" />&nbsp;&nbsp;<input type="text" name="form[update]['.$value->id.'][sequence]" value="'.$value->sequence.'" /><input class="deleteOption '. $value->id .'" type="button" value="删除" /><br/>';
		}
		$option = '<tr><td width="20%"><label>' . $label . '</label></td><td><select class="'.$className.$name.'" '.$formName.'>' . $subOptions .'</select>'. $isMustLogo.'</td></tr>';
		$hiddenoption .= '<span class="tipOption '.$name.'"></span><input class="addOptionButton" type="button" value="添加选项" /><input class="submitOption" type="button" value="提交" /></div>' ;
		$option = $option.$hiddenoption;
		return $option ;
	}

	public function MultipleOutsideSelect($formfield)
	{
		$name = $this->getCoverage($formfield, 'name');
		$label = $this->getCoverage($formfield,'label');
		$formName = $this->isUDF($formfield);
		$fillValue = $this->getFillValue($name, $this->getCoverage($formfield,'defaultValue'));

		$exSelectObj = Category::model()->findAllByAttributes(array('name_space'=>$this->getCoverage($formfield, 'nameSpace')));
		$subOptions = '<option value=""></option>';
		foreach ($exSelectObj as $value)
		{
			$select = ($value == $fillValue) ? 'selected="selected"' : '' ;
			$subOptions .= '<option '.$select.' value="'. $value->id .'">'.str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $value->level - 1).$value->name.'</option>' ;
		}
		$option = '<tr><td width="20%"><label>' .$label. '</label></td><td><select '.$formName.'>' .$subOptions.'</select></td></tr>';
		return $option ;
	}

	public function innerRadio($formfield)
	{
		$name = $this->getCoverage($formfield, 'name');
		$label = $this->getCoverage($formfield,'label');
		$formName = $this->isUDF($formfield);
		$fillValue = $this->getFillValue($name, $this->getCoverage($formfield,'defaultValue'));

		$strToArray = explode(',',$this->getCoverage($formfield, 'attr' ));
		$subOptions = '';
		foreach ($strToArray as $val)
		{
			$checked = ($val == $fillValue) ? 'checked="checked"' : '' ;
			$subOptions .= '<input '.$checked.' '.$formName.' type="radio" value="'.$val.'"/>'.$val;
		}
		$option = '<tr><td width="20%"><label>' .$label. '</label></td><td>'.$subOptions.'</td></tr>';
		return $option ;
	}

	public function outsideRadio($formfield)
	{
		$name = $this->getCoverage($formfield, 'name');
		$label = $this->getCoverage($formfield,'label');
		$formName = $this->isUDF($formfield);
		$fillValue = $this->getFillValue($name, $this->getCoverage($formfield,'defaultValue'));

		$tableModelName = $this->getCoverage($formfield, 'tableModelName');
		$condition = $this->getCoverage($formfield, 'condition');
		$key = $this->getCoverage($formfield, 'key');
		$obj = new $tableModelName();
		$source = $obj->findByAttributes($condition);
		$attr = $source->$key ;
		$strToArray = explode(',',$attr);
		$subOptions = '';
		foreach ($strToArray as $val)
		{
			$checked = ($val == $fillValue) ? 'checked="checked"' : '' ;
			$subOptions .= '<input '.$checked.' '.$formName.' type="radio" value="'.$val.'"/>'.$val;
		}
		$option = '<tr><td width="20%"><label>' .$label. '</label></td><td>'.$subOptions.'</td></tr>';
		return $option ;
	}

	public function innerCheckbox($formfield)
	{
		$name = $this->getCoverage($formfield, 'name');
		$label = $this->getCoverage($formfield,'label');
		$formName = $this->isUDF($formfield);
		$fillValue = $this->getFillValue($name, $this->getCoverage($formfield,'defaultValue'));

		$strToArray = explode(',',$this->getCoverage($formfield, 'attr' ));
		$subOptions = '';
		foreach ($strToArray as $val)
		{
			$checked = ($val == $fillValue) ? 'checked="checked"' : '' ;
			$subOptions .= '<input '.$checked.' '.substr($formName,0,strlen($formName)-1).'[]" type="checkbox" value="'.$val.'"/>'.$val;
		}
		$option = '<tr><td width="20%"><label>' .$label. '</label></td><td>'.$subOptions.'</td></tr>';
		return $option ;
	}

	public function outsideCheckbox($formfield)
	{
		$name = $this->getCoverage($formfield, 'name');
		$label = $this->getCoverage($formfield,'label');
		$formName = $this->isUDF($formfield);
		$fillValue = $this->getFillValue($name, $this->getCoverage($formfield,'defaultValue'));

		$tableModelName = $this->getCoverage($formfield, 'tableModelName');
		$condition = $this->getCoverage($formfield, 'condition');
		$key = $this->getCoverage($formfield, 'key');
		$obj = new $tableModelName();
		$condition = $this->separatedColonsGetConditions($condition);
		$source = $obj->findByAttributes($condition);
		$strToArray = explode(',',$source->$key);
		$subOptions = '';
		foreach ($strToArray as $val)
		{
			$checked = ($val == $fillValue) ? 'checked="checked"' : '' ;
			$subOptions .= '<input '.$checked.' '.substr($formName,0,strlen($formName)-1).'[]" type="checkbox" value="'.$val.'"/>'.$val;
		}
		$option = '<tr><td width="20%"><label>' .$label. '</label></td><td>'.$subOptions.'</td></tr>';
		return $option ;
	}

	public function password($formfield)
	{
		$option =  '<tr><td width="20%"><label>' . $this->getCoverage($formfield, 'label') . '</label></td>
					<td><input type="password" name="form[password]"/></td><td></td></tr>';
		$option .=  '<tr><td width="20%"><label>确认密码</label></td><td><input type="password" class="rePassword" label="password"/></td><td></td></tr>';
		return $option;
	}

	public function monthPicker($formfield)
	{
		$name = $this->getCoverage($formfield, 'name');
		$label = $this->getCoverage($formfield,'label');
		$formName = $this->isUDF($formfield);
		$fillValue = $this->getFillValue($name, $this->getCoverage($formfield,'defaultValue'));

		$suboption = '<script src="/js/jquery/jquery.ui.datepicker.js" type="text/javascript"></script>';
		$option = '<tr><td width="20%"><label>' .$label. '</label></td>
					<td><input label="monthPicker" '.$formName.' value="'.$fillValue.'"/>'.$suboption.'</td></tr>';
		return $option ;
	}

	public function datePicker($formfield)
	{
		$name = $this->getCoverage($formfield, 'name');
		$label = $this->getCoverage($formfield,'label');
		$formName = $this->isUDF($formfield);
		$fillValue = $this->getFillValue($name, $this->getCoverage($formfield,'defaultValue'));

		$suboption = '<script src="/js/jquery/jquery.ui.datepicker.js" type="text/javascript"></script>';
		$option =  '<tr><td width="20%"><label>' .$label. '</label></td>
					<td><input label="datePicker" '.$formName.' value="'.$fillValue.'"/>'.$suboption.'</td></tr>';
		return $option ;
	}

	public function provincePicker($formfield)
	{
		$name = $this->getCoverage($formfield, 'name');
		$label = $this->getCoverage($formfield,'label');
		$formName = $this->isUDF($formfield);
		$fillValue = $this->getFillValue($name, $this->getCoverage($formfield,'defaultValue'));

		if (isset($fillValue) && $fillValue){
			$city = explode(',',$fillValue) ;
			$js = 'var loc = new Location();
					$(".ChinaArea").jChinaArea({
						'."s1: '$city[0]'," .  "s2: '$city[1]'," .'
						
					})';
		}else{
			$js = '$(".ChinaArea").jChinaArea();' ;
		}
		$fillValue = $fillValue?$fillValue:'北京,北京';
		$suboption = '	<script src="/js/location.js" type="text/javascript"></script>
						<script src="/js/YLChinaArea.js" type="text/javascript"></script>
						<script> $(function () {
						'.$js.'
						$("#province,#city").live("change", function () {
							$(\'input['.$formName.']\').val($("#province").find("option:selected").text() + "," + $("#city").find("option:selected").text())
						})
					}); </script> ';

		$option = '<tr><td width="20%"><label>' .$label. '</label></td>
					<td><div class="ChinaArea">
						<select id="province" style="width: 100px;"></select>
						<select id="city" style="width: 100px;"></select>
					</div></td><td><input type="hidden" '.$formName.' class="hometown" value="'.$fillValue.'"/></td>'.$suboption.'</tr>';
		return $option ;
	}

	public function postAttach($formfield, $name=null, $label=null )
	{
		if ($formfield){
			$name = $this->getCoverage($formfield,'name');
			$label = $this->getCoverage($formfield,'label');
		}
		$suboption =  <<<EOF
<link rel='stylesheet' type='text/css' href='/uploadify/uploadify.css' />
<script src="/uploadify/jquery.uploadify-3.1.js" type="text/javascript"></script>
<script>
$(function(){
	$("#file_upload_{$name}").uploadify({
		//'queueID'  : 'file_box',
		'swf'			 : '/uploadify/uploadify.swf',
		'uploader'		: '/index.php/CommonInterface/UploadAttach',
		'cancelImg'		  : '/uploadify/uploadify-cancel.png',
		'onUploadSuccess' : function(file, data, response) {
			$('#file_box_{$name}').append( '<div class="uploadify-queue-item" ><div class="cancel"><a class="uploadify-queue" href="javascript:fileDelete(\''+data+'\')">X</a></div><span class="fileName">'+file.name+'</span><span class="data"> - 完成</span><input type="hidden" name="form['+data+'][id]" value="'+data+'"/><input type="hidden" name="form['+data+'][name]" value="'+file.name+'"/><input type="hidden" name="form['+data+'][ext]" value="'+file.type+'"/></div>' )
		}
	});
	$('#file_upload_{$name}').uploadify('settings','buttonText','选择文件');
	$('.uploadify-queue').live('click',function(){
		$(this).closest('.uploadify-queue-item').remove()
	});
})</script>
EOF;
		$option = '<tr><td width="20%"><label>' . $label . '</label></td><td><input type="file" name="file_upload_'. $name .'" id="file_upload_'. $name .'" /><div class="file_box" id="file_box_'. $name .'"></div></td><td>'.$suboption.'</td></tr>';
		return $option ;
	}

	public function uploadPic($formfield, $name=null, $label=null)
	{
		if ($formfield){
			$name = $this->getCoverage($formfield,'name');
			$label = $this->getCoverage($formfield,'label');
		}
		$suboption = 	'<script src="/js/jquery/jquery.color.js" type="text/javascript"></script>
						<script src="/js/jquery/jquery.Jcrop.js" type="text/javascript"></script>
						<link rel="stylesheet" type="text/css" href="/css/jquery.Jcrop.css" />';
		if (isset($this->model->avatar)){
			$option = '<tr><td width="20%"><label>' . $label . '</label></td><td class="pictrueLoad"><img src="'.$this->model->avatar.'"/></td><td><button onclick="return false" class="uploadPic '.$name.'">上传图片</button></td>'.$suboption.'</tr>';
		}else{
			$option = '<tr><td width="20%"><label>' . $label . '</label></td><td class="pictrueLoad"></td><td><button onclick="return false" class="uploadPic '.$name.'">上传图片</button></td>'.$suboption.'</tr>';
		}
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
				});</script>';	 
		}
		return $isMustLogo;
	}

	private function addRules($rules, $formName){
                $type = '';
		$ruleJS = '';
		if ($rules){
			switch ($rules)
			{
				case '电话': $type = 'regex.phone' ;   break;
				case '手机': $type = 'regex.mobile' ;  break;
				case '邮箱': $type = 'regex.email' ;   break;
				case '邮编': $type = 'regex.zipcode' ;   break;
				case '身份证': $type = 'regex.IDCard' ;  break;
				default: break;
			}
                     
			$ruleJS = '<script>
				$(function () {
					$(\'input['.$formName.']\').live("blur", function () {
						checkRules(this, '.$type.');
					})
				});
				</script>';
		}
		return $ruleJS;
	}

	private function isUDF($formfield){
		$name = $this->getCoverage($formfield, 'name');
		return ($this->getCoverage($formfield, 'category')=='udf') ? 'name="form[udf_'.$name.']"' : 'name="form['.$name.']"' ;
	}

	private function getFillValue($name, $defaultValue){
		$fillValue = isset($this->model->$name) ? $this->model->$name : null ;
		if (!$fillValue && $defaultValue){
			$fillValue = $defaultValue;
		}
		//自定义表单内容填充, pa_form_field表
		$cover = 'field_id_cover'.$this->id ;
		if (!$fillValue && isset($this->model->$cover)){
			$formValue = json_decode($this->model->$cover);
			$fillValue = isset($formValue->$name) ? $formValue->$name: null ;
		}
		return $fillValue;
	}
        
        //在数据库中获取对应的key值
	public function getCoverage($formfield, $key=null)
	{
		$cover = 'field_id_cover'.$this->id ;
		$obj = json_decode($formfield->$cover);
		return isset($obj->$key) ? $obj->$key : null ;
	}
	
	public function separatedColonsGetConditions($string)
	{
		$condition = explode(':',$string);
		foreach ($condition as $key=>$value) {
			if ($key%2){
				$arr[$value] = $condition[$key+1];
			}
		}
		return $condition ;
	}

	public function setEnv($formfield, $id=null)
	{
		$module = Yii::app()->homeUrl;
		$controller = Yii::app()->controller->id ;
		$action = Yii::app()->controller->action->id ;
                
		$condition2 = json_decode($formfield->field_id_condition2);
		if ((isset($condition2->action) && $condition2->action==$action) && (isset($condition2->controller)  && $condition2->controller==$controller) &&  (isset($condition2->module) && $condition2->module==$module)){
                    if ($this->checkParameter($condition2->parameter)) 
                    {
                        return $this->id = 2;
                    }   
		}
		$condition1 = json_decode($formfield->field_id_condition1);
		if ((isset($condition1->action) && $condition1->action==$action) && (isset($condition1->controller)  && $condition1->controller==$controller) &&  (isset($condition1->module) && $condition1->module==$module)){	
		    if ($this->checkParameter($condition1->parameter))
                    {
                        return $this->id = 1;
                    }
		}
		$condition0 = json_decode($formfield->field_id_condition0);
		if ((isset($condition0->action) && $condition0->action==$action) && (isset($condition0->controller)  && $condition0->controller==$controller) &&  (isset($condition0->module) && $condition0->module==$module)){	
		    if ($this->checkParameter($condition0->parameter)) 
                    {
                        return $this->id = 0;
                    }
		}
		return $this->id = null;
	}
        
        private function checkParameter($param)
        {
            if ($param != null)
            {
                $serverUrl = $_SERVER['REQUEST_URI'];
                return strpos($serverUrl, $param);
            }
            else 
            {
                return true; 
            }
        }

        
	public function getCondition($formfield, $key=null, $id=null )
	{
		$cover = 'field_id_condition'.$id ;
		$obj = json_decode($formfield->$cover);
		return isset($obj->$key) ? $obj->$key : null ;
	}
}