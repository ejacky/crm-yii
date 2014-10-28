<?php
/**
 *
 * 说明文档    document\FormExplain\自定义表单使用文档.xlsx
 * @author Administrator
 *
 */

// Maybe we can need two parameters to __construct 
//$model and formField that we can reduce some code .
class NewInput
{
	private $model ;
	private $id = null ;
        private $controller;
        
        private $name;
        private $label;
        private $attr;
        private $nameSpace;
        private $category;
        
		private $formField;
		private $type;
		private $formName;
		private $fillValue;
		private $isMustLogo;
		private $rules;
		private $explain;
        
      //  private $formField;
        /*
         * for backup
        private $action;
        private $controller;
        private $module;
         * 
         */

	function __construct($formField, $model = null)
	{
            /* for backup
                $this->module = Yii::app()->homeUrl;
                $this->controller = Yii::app()->controller->id;
                $this->action = Yii::app()->controller->action->id;
             * 
             */
                                $this->model = $model ;
                                $this->formField = $formField;
		                $this->id = $this->setEnv($formField);
				/*
				$idName = 'field_id'.$id;
				foreach ($fields as $value)
				{
				    if ($value->id == $formField->$idName)
					{
					    $field = $value;
					}
				}
				$this->type = $field->type;
				if ($formField->$idName != 0)
				{

				}
				*/
				$this->name = $this->getCoverage($formField, 'name');                      
				$this->label = $this->getCoverage($formField, 'label');
                                $this->attr = $this->getCoverage($formField, 'attr');
				
				$tempType = $this->getCoverage($formField, 'textType');
				if ($tempType)
				{
				    $this->type = $tempType;
				}
				else 
				{
				    $this->type = 'text';
				}
				$this->formName = $this->isUDF($formField);
				$this->fillValue = $this->getFillValue($this->name, $this->getCoverage($formField,'defaultValue'));
				$this->isMustLogo = $this->checkMust($this->getCoverage($formField, 'isMust'),$this->name, $this->label);
				$this->rules = $this->addRules($this->getCoverage($formField, 'rules'),$this->formName);
				$this->explain = $this->getCoverage($formField, 'explain');
				
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
        
        private function addTrHead($idExis = false)
        {
//                if ($idExis)
//                {
//                       $trId = 'id="field_tr_ '. $this->name . '"'; 
//                }
//                else 
//                {
//                        $trId = null;
//                }
                return '<tr>';
        }

        private function addTrEnd()
        {
                return '</tr>';
        }
        
        private function addTdHead($width = '', $idExis = false, $item = 'td')
        {
                if ($idExis)
                {
                        $tdId = 'id="field_' . $item . '_' . $this->name . '"';
                }
                else 
                {
                        $tdId = '';
                }
                if ($width != '')
                {
                        $tdWidth = 'width="' . $width. '"';
                }
                else
                {
                        $tdWidth = '';
                }
                return '<td ' . $tdWidth . $tdId . '>';
        }
        
        private function addTdEnd()
        {
                return '</td>';
        }
        
        private function addlabelHead()
        {
                return '<label id="field_label_' . $this->name . '">';
        }
        
        private function addLabelEnd()
        {
                return '</label>';
        }
        
                public function emptyLabel()
        {
                $option = '<tr><td class=" ' . $this->name. ' "></td><td id="just_for_test"></td></tr>';
                return $option;
        }
	
	
         public function text1()
	{
				$option = ' <tr id="field_tr1_' . $this->name . '"><td id="field_td1_' . $this->name . '" width="20%" class="label-name"><label id="field_label_' . $this->name . '">'.$this->label.'</label><span style="color:red" class="span2-'.$this->name.'"></span></td>
					<td id="field_td2_' . $this->name . '"><input id="field_item_' . $this->name . '" class="'.$this->name.'" label="'.$this->name.'" type="'.$this->type.'" '.$this->formName.' value="'.$this->fillValue.'">'.$this->isMustLogo.$this->rules.'</td>
					<td id="field_td3_' . $this->name . '"><span class="span-'.$this->name.'"></span></td></tr>
					<tr id="field_tr2_' . $this->name . '"><td id="field_td4_' . $this->name . '" width="20%"></td><td id="field_td5_' . $this->name . '"><span style="color:grey;font-size: 1em">'.$this->explain.'</span></td></tr>';
		return $option ;
	}
        
        public function text2()
        {
                $option = $this->addTrHead() . $this->addTdHead('20%') . $this->addLabelHead() . $this->label . $this->addLabelEnd() . '<span style="color:red" class="span2-'.$this->name.'"></span>' . $this->addTdEnd()
                        . $this->addTdHead('', true , 'content') . '<input id="field_item_' . $this->name . '" class="'.$this->name.'" label="'.$this->name.'" type="'.$this->type.'" '.$this->formName.' value="'.$this->fillValue.'">'.$this->isMustLogo.$this->rules . $this->addTdEnd()
                        . $this->addTdHead() . '<span class="span-'.$this->name.'"></span>' . $this->addTdEnd() . $this->addTrEnd()
                        . $this->addTrHead() . $this->addTdHead('20%') . $this->addTdEnd() . $this->addTdHead() . '<span class="explain" style="color:grey;font-size: 1em">'.$this->explain.'</span>' . $this->addTdEnd() . $this->addTrEnd();
                return $option;
        }
        
        public function text()
        {
                $option = '<input id="field_item_' . $this->name . '" class="'.$this->name.'" label="'.$this->name.'" type="'.$this->type.'" '.$this->formName.' value="'.$this->fillValue.'">'.$this->isMustLogo.$this->rules;
                return $option;
        }
        
        public function label()
        {
                $key = $this->getCoverage($this->formField, 'key');
		$objName = $this->getCoverage($this->formField, 'tableModelName');
                $idName = 'field_id_condition' . $this->id;
                $keyValue = json_decode($this->formField->$idName)->parameter;
                //$labelValue = $objName::model()->findByPk($_GET[$keyValue])->name;
                $option = '<tr><td width="20%" class=" ' . $this->name. ' "> <label>' . $this->label . '</label></td><td>' .$labelValue . '</td><input type="hidden" name="form[' . $this->name . ']" value="' . $_GET[$keyValue]. '"></tr>';
                
 //               $option = '';
                return $option;
        }

	public function textarea1()
	{
		$option = '<tr id="field_tr1_' . $this->name . '">
                        <td width="20%" id="field_td1_' . $this->name . '">
                        <label id="field_label_' . $this->name . '">' .$this->label. '</label>
                                <span style="color:red" class="span2-'.$this->name.'"></span>
                                        </td>
                                        <td id="field_td2_' . $this->name . '">
                                        <textarea '.$this->formName.' id="field_item_' . $this->name . '">'.$this->fillValue.'</textarea>'. $this->isMustLogo. '</td></tr>
				<tr id="field_tr2_' . $this->name . '"><td id="field_td3_' . $this->name . '" width="20%"></td><td id="field_td4_' . $this->name . '"><span style="color:grey;font-size: 1em">'.$this->explain.'</span></td></tr>';
		return $option ;
	}
        
        public function textarea2()
        {
                $option = $this->addTrHead() . $this->addTdHead('20%') . $this->addlabelHead() .$this->label . $this->addLabelEnd() . '<span style="color:red" class="span2-'.$this->name.'"></span>' .$this->addTdEnd() . $this->addTdHead('', true , 'content') . '
                        <textarea '.$this->formName.' id="field_item_' . $this->name . '">'.$this->fillValue.'</textarea>'. $this->isMustLogo . $this->addTdEnd() . $this->addTrEnd() .
                        $this->addTrHead() . $this->addTdHead('20%') . $this->addTdEnd() . $this->addTdHead() . '<span style="color:grey;font-size: 1em">'.$this->explain.'</span>' . $this->addTdEnd() . $this->addTrEnd();
                return $option;
        }
        
        public function textarea()
        {
                $option = '';
                return $option;
        }

	public function SingleInnerSelect()
	{
		$strToArray = explode(',',$this->attr);
		$subOptions = '';
		foreach ($strToArray as $value)
		{
			$checked = ($value == $this->fillValue) ? 'selected="selected"'  : '' ;
			$subOptions .= '<option value='.$value.' '.$checked.'>'.$value.'</option>';
		}
		$option = '<tr><td width="20%"><label>' .$this->label. '</label></td><td><select '.$this->formName.'>'.$subOptions.'</select></td></tr>';
		return $option ;
	}

	public function SingleOutsideSelect()
	{
		$key = $this->getCoverage($this->formField, 'key');
		$objName = $this->getCoverage($this->formField, 'tableModelName');
//                var_dump($this->formField);exit;
		$obj = new $objName();
		$exSelectObj = $obj->findAll();
		$subOptions = '';
		foreach ($exSelectObj as $value)
		{
			$select = ($value->id == $this->fillValue) ? 'selected="selected"' : '' ;
			$subOptions .= '<option value=' . $value->id . ' '.$select.'>' .$value->$key.'</option>';
		}
		$option = '<tr><td width="20%"><label>' .$this->label. '</label></td><td><select '.$this->formName.'>' .$subOptions.'</select></td></tr>';
		return $option ;
	}

	public function SingleAndCanAddOptionSelect($name=null, $label=null)
	{
		$className = get_class($this->model); //$className = $this->getCoverage($formField,'tableModelName'); 可以修改成动态条件
		$isMustLogo = '<span class="addOption '.$this->name.'"> <input type="button" value="增加选项"></span>';
		$attr = SingleCategory::model()->findAll('nameSpace=:name and name=:na order by sequence', array(':name'=>$className, ':na'=>$this->name));
		$subOptions = '';
		$hiddenoption = '<div  class="hidden popoption '.$this->name.'"><h3>'.$className.'</h3><input type="hidden" name="nameSpace" value="'. $className .'" /><input type="hidden" name="formName" value="'. $this->name .'" />' ;
		$hiddenoption .= '<label>添加数据键值</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label class="label">'. $this->label .'</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>排序</label><br/>';
                foreach ($attr as $value)
		{
			$subOptions .= '<option value=' . $value->key . '>' . $value->value .'</option>';
			$hiddenoption .= '<input type="text" name="form[update]['.$value->id.'][key]" value="'. $value->key .'" />&nbsp;&nbsp;<input type="text" name="form[update]['.$value->id.'][value]" value="'. $value->value .'" />&nbsp;&nbsp;<input type="text" name="form[update]['.$value->id.'][sequence]" value="'.$value->sequence.'" /><input class="deleteOption '. $value->id .'" type="button" value="删除" /><br/>';
		}
		$option = '<tr><td width="20%"><label>' . $this->label . '</label></td><td><select class="'.$className.$this->name.'" '.$this->formName.'>' . $subOptions .'</select>'. $this->isMustLogo.'</td></tr>';
		$hiddenoption .= '<span class="tipOption '.$this->name.'"></span><input class="addOptionButton" type="button" value="添加选项" /><input class="submitOption" type="button" value="提交" /></div>' ;
		$option = $option.$hiddenoption;
		return $option ;
	}

	public function MultipleOutsideSelect()
	{

		$exSelectObj = Category::model()->findAllByAttributes(array('name_space'=>$this->nameSpace));
		$subOptions = '<option value=""></option>';
		foreach ($exSelectObj as $value)
		{
			$select = ($value == $fillValue) ? 'selected="selected"' : '' ;
			$subOptions .= '<option '.$select.' value="'. $value->id .'">'.str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $value->level - 1).$value->name.'</option>' ;
		}
		$option = '<tr><td width="20%"><label>' .$label. '</label></td><td><select '.$formName.'>' .$subOptions.'</select></td></tr>';
		return $option ;
	}

	public function innerRadio()
	{

		$strToArray = explode(',',$this->attr);
		$subOptions = '';
		foreach ($strToArray as $val)
		{
			$checked = ($val == $this->fillValue) ? 'checked="checked"' : '' ;
			$subOptions .= '<input '.$checked.' '.$this->formName.' type="radio" value="'.$val.'"/>'.$val;
		}
		$option = '<tr><td width="20%"><label>' .$this->label. '</label></td><td>'.$subOptions.'</td></tr>';
		return $option ;
	}

	public function outsideRadio()
	{

		$tableModelName = $this->getCoverage($this->formField, 'tableModelName');
		$condition = $this->getCoverage($this->formField, 'condition');
		$key = $this->getCoverage($this->formField, 'key');
		$obj = new $tableModelName();
		$source = $obj->findByAttributes($condition);
		$attr = $source->$key ;
		$strToArray = explode(',',$attr);
		$subOptions = '';
		foreach ($strToArray as $val)
		{
			$checked = ($val == $this->fillValue) ? 'checked="checked"' : '' ;
			$subOptions .= '<input '.$checked.' '.$this->formName.' type="radio" value="'.$val.'"/>'.$val;
		}
		$option = '<tr><td width="20%"><label>' .$this->label. '</label></td><td>'.$subOptions.'</td></tr>';
		return $option ;
	}

	public function innerCheckbox()
	{

		$strToArray = explode(',',$this->attr);
		$subOptions = '';
		foreach ($strToArray as $val)
		{
			$checked = ($val == $this->fillValue) ? 'checked="checked"' : '' ;
			$subOptions .= '<input '.$checked.' '.substr($this->formName,0,strlen($this->formName)-1).'[]" type="checkbox" value="'.$val.'"/>'.$val;
		}
		$option = '<tr><td width="20%"><label>' .$this->label. '</label></td><td>'.$subOptions.'</td></tr>';
		return $option ;
	}

	public function outsideCheckbox()
	{

		$tableModelName = $this->getCoverage($this->formField, 'tableModelName');
		$condition = $this->getCoverage($this->formField, 'condition');
		$key = $this->getCoverage($this->formField, 'key');
		$obj = new $tableModelName();
		$condition = $this->separatedColonsGetConditions($condition);
		$source = $obj->findByAttributes($condition);
		$strToArray = explode(',',$source->$key);
		$subOptions = '';
		foreach ($strToArray as $val)
		{
			$checked = ($val == $this->fillValue) ? 'checked="checked"' : '' ;
			$subOptions .= '<input '.$checked.' '.substr($this->formName,0,strlen($this->formName)-1).'[]" type="checkbox" value="'.$val.'"/>'.$val;
		}
		$option = '<tr><td width="20%"><label>' .$this->label. '</label></td><td>'.$subOptions.'</td></tr>';
		return $option ;
	}

	public function password()
	{
		$option =  '<tr><td width="20%"><label>' . $this->label . '</label></td>
					<td><input type="password" name="form[password]"/></td><td></td></tr>';
		$option .=  '<tr><td width="20%"><label>确认密码</label></td><td><input type="password" class="rePassword" label="password"/></td><td></td></tr>';
		return $option;
	}

	public function monthPicker()
	{

		$suboption = '<script src="/js/jquery/jquery.ui.datepicker.js" type="text/javascript"></script>';
		$option = '<tr><td width="20%"><label>' .$this->label. '</label></td>
					<td><input label="monthPicker" '.$this->formName.' value="'.$this->fillValue.'"/>'.$suboption.'</td></tr>';
		return $option ;
	}

	public function datePicker()
	{
		$suboption = '<script src="/js/jquery/jquery.ui.datepicker.js" type="text/javascript"></script>';
		$option =  '<tr><td width="20%"><label>' .$this->label. '</label></td>
					<td><input label="datePicker" '.$this->formName.' value="'.$this->fillValue.'"/>'.$suboption.'</td></tr>';
		return $option ;
	}

	public function provincePicker()
	{
		if (isset($this->fillValue) && $this->fillValue){
			$city = explode(',',$this->fillValue) ;
			$js = 'var loc = new Location();
					$(".ChinaArea").jChinaArea({
						'."s1: '$city[0]'," .  "s2: '$city[1]'," .'
						
					})';
		}else{
			$js = '$(".ChinaArea").jChinaArea();' ;
		}
		$fillValue = $this->fillValue?$this->fillValue:'北京,北京';
		$suboption = '	<script src="/js/location.js" type="text/javascript"></script>
						<script src="/js/YLChinaArea.js" type="text/javascript"></script>
						<script> $(function () {
						'.$js.'
						$("#province,#city").live("change", function () {
							$(\'input['.$this->formName.']\').val($("#province").find("option:selected").text() + "," + $("#city").find("option:selected").text())
						})
					}); </script> ';

		$option = '<tr><td width="20%"><label>' .$this->label. '</label></td>
					<td><div class="ChinaArea">
						<select id="province" style="width: 100px;"></select>
						<select id="city" style="width: 100px;"></select>
					</div></td><td><input type="hidden" '.$this->formName.' class="hometown" value="'.$this->fillValue.'"/></td>'.$suboption.'</tr>';
		return $option ;
	}

	public function postAttach($formField, $name=null, $label=null )
	{
		if ($formField){
			$name = $this->getCoverage($formField,'name');
			$label = $this->getCoverage($formField,'label');
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

	public function uploadPic($formField, $name=null, $label=null)
	{
		if ($formField){
			$name = $this->getCoverage($formField,'name');
			$label = $this->getCoverage($formField,'label');
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

	private function isUDF(){
		return ($this->category == 'udf') ? 'name="form[udf_'.$this->name.']"' : 'name="form['.$this->name.']"' ;
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
	public function getCoverage($formField, $key=null)
	{
		$cover = 'field_id_cover'.$this->id ;
		$obj = json_decode($formField->$cover);
                //var_dump($this);exit;
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

	public function setEnv($formField, $id=null)
	{
		$module = Yii::app()->homeUrl;
		$controller = Yii::app()->controller->id ;
		$action = Yii::app()->controller->action->id ;
                
		$condition2 = json_decode($this->formField->field_id_condition2);
		if ((isset($condition2->action) && $condition2->action==$action) && (isset($condition2->controller)  && $condition2->controller==$controller) &&  (isset($condition2->module) && $condition2->module==$module)){
                    if ($this->checkParameter($condition2->parameter)) 
                    {
                        return $this->id = 2;
                    }   
		}
		$condition1 = json_decode($this->formField->field_id_condition1);
		if ((isset($condition1->action) && $condition1->action==$action) && (isset($condition1->controller)  && $condition1->controller==$controller) &&  (isset($condition1->module) && $condition1->module==$module)){	
		    if ($this->checkParameter($condition1->parameter))
                    {
                        return $this->id = 1;
                    }
		}
		$condition0 = json_decode($this->formField->field_id_condition0);
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

        
	public function getCondition($formField, $key=null, $id=null )
	{
		$cover = 'field_id_condition'.$id ;
		$obj = json_decode($formField->$cover);
		return isset($obj->$key) ? $obj->$key : null ;
	}
}