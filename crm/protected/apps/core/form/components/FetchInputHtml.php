<?php
/**
 *
 * 说明文档    document\FormExplain\自定义表单使用文档.xlsx
 * @author Administrator
 *
 */
class FetchInputHtml
{      
	private $conditionId= null ;

	function __construct($formField) 
        {
                $this->formField = $formField;           
	}  
        
        private static function getCustomValidator($extraAttr) {
                $customValidator = '';
                foreach ($extraAttr as $name => $value) {
                        if ($name == 'customValidator') {
                                $customValidator = $value;
                        }
                }
                return $customValidator;
        }
        
        private static function getCheckAttr($extraAttr) {
                $checkAttr = '';
                foreach ($extraAttr as $name => $value) {
                        if ($name == 'checkAttr') {
                                $checkAttr = $value;
                        }
                }
                return $checkAttr;
        }
        
        private static function getInnerData($extraAttr) {
                $data = array();
                foreach ($extraAttr as $name => $value) {
                        if ($name == 'attr') {
                                $strToArr = explode(',', $value);
                                foreach ($strToArr as $subName => $subValue) {
                                        $data[$subValue] = $subValue;
                                }
                        }    
                }
                return $data;
        }
        /**
         *
         * @param type $extraAttr
         * @return string 
         */
        
        private static function getSpecialData($extraAttr) {
                return js;  
        }
        
        private static function getOutsideData($extraAttr) {
                $data = array();
                foreach ($extraAttr as $name => $value)
                {
                        if ($name == 'tableModelName')
                        {
                                $tableModelName = $value;
                        }
                        if ($name == 'key')
                        {   
                                if ($value != '')
                                {
                                        $key = $value;
                                }
                                else
                                {
                                        $key = 'id';
                                }
                        }
                        if ($name == 'condition')
                        {
                                $condition = $value;
                        }
                        else
                        {
                                $condition = '';
                        }
                }
                $objName = new $tableModelName;
                
                foreach ($objName->findAll($condition) as $subModel)
                {
                        if ($tableModelName == 'PaForm')
                        {
                                $data[$subModel->name] = $subModel->$key;
                        }
                        else
                        {
                                $data[$subModel->id] = $subModel->$key;
                        }
                }
                return $data;
        }
        
        private static function getNameByFormName($formName) {
                $name = '';
                if (preg_match('/\[(.*?)\]/', $formName, $match))
                {
                        $name = $match[1];
                }
                return $name;
        }
             
        public static function dividedModel($formName) {
                
        }
        
        public function emptyLabel($formName) {
                $option = '<tr><td class=" ' . $formName. ' "></td><td id="just_for_test"></td></tr>';
                return $option;
        }
        
        public function text($formName, $fillValue, $htmlOptions, $extraAttr) {
                $checkAttr = self::getCheckAttr($extraAttr);
                $option = CHtml::textField($formName, $fillValue, $htmlOptions) . $checkAttr . self::getCustomValidator($extraAttr);
                return $option;
        }
        
        public function textarea($formName, $fillValue, $htmlOptions, $extraAttr) {
                $option = CHtml::textArea($formName, $fillValue, $htmlOptions) . self::getCustomValidator($extraAttr);
                return $option;
        }
        
        public function label($formName, $fillValue)
        {
                $option = CHtml::hiddenField($formName, $fillValue); // something wrong about $value
                return $option;
        }
        
	public function singleInnerSelect($formName, $fillValue, $htmlOptions, $extraAttr)
	{
                $data = self::getInnerData($extraAttr);
                $option = CHtml::dropDownList($formName, $fillValue, $data, $htmlOptions) . self::getCustomValidator($extraAttr);
                return $option ;
	}

	public function singleOutsideSelect($formName,$fillValue,$htmlOptions, $extraAttr)
	{ 
                $data = self::getOutsideData($extraAttr);
                $option = CHtml::dropDownList($formName, $fillValue, $data) . self::getCustomValidator($extraAttr);
                return $option ;
	}
        
        public function singleSpecialSelect($formName, $filValue, $htmlOPtions, $extraAttr) {
                return CHtml::dropDownList($formName, 'fillValue', array()) . self::getCustomValidator($extraAttr);
        }
        
        public function singleAndCanAddOptionSelect($formName, $fillValue, $htmlOptions, $extraAttr)
        {
                $name = self::getNameByFormName($formName);
                foreach ($extraAttr as $temp_name => $value)
                {
                        if ($temp_name == 'tableModelName')
                        {
                                $tableModelName = $value;
                        }
                        else 
                        {
                                $tableModelName = 'FormField';
                        }
                }
                $label = '名称';
 
	        $isMustLogo = '<span class="addOption '.$name.'"><input type="button" value="增加选项"></span>';
		$attr = SingleCategory::model()->findAll('nameSpace=:name and name=:na order by sequence', array(':name'=>'FormField', ':na'=>$name));
		$subOptions = '';
		$hiddenoption = '<div  class="hidden popoption '.$name.'"><h3>'.$tableModelName.'</h3><input type="hidden" name="nameSpace" value="'. $tableModelName .'" /><input type="hidden" name="formName" value="'. $name .'" />' ;
		$hiddenoption .= '<label>添加数据键值</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label class="label">'. $label .'</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>排序</label><br/>';
                
                foreach ($attr as $value)
		{   
                        $select = ($value->key == $fillValue) ? 'selected="selected"' : '' ;
			$subOptions .= '<option value=' . $value->key . ' '.$select.'>' . $value->value .'</option>';
			$hiddenoption .= '<input type="text" name="form[update]['.$value->id.'][key]" value="'. $value->key .'" />&nbsp;&nbsp;<input type="text" name="form[update]['.$value->id.'][value]" value="'. $value->value .'" />&nbsp;&nbsp;<input type="text" name="form[update]['.$value->id.'][sequence]" value="'.$value->sequence.'" /><input class="deleteOption '. $value->id .'" type="button" value="删除" /><br/>';
		}
                
		$option = '<select class="'.$tableModelName.$name.'" name='.$formName.'>' . $subOptions .'</select>'. $isMustLogo;
		$hiddenoption .= '<span class="tipOption '.$name.'"></span><input class="addOptionButton" type="button" value="添加选项" /><input class="submitOption" type="button" value="提交" /></div>' ;
		$option = $option.$hiddenoption;
		return $option ;
        }

	public function multipleOutsideSelect($formName, $fillValue)
	{
		$exSelectObj = Category::model()->findAllByAttributes(array('name_space'=>$this->nameSpace));
		$subOptions = '<option value=""></option>';
		foreach ($exSelectObj as $value)
		{
			$select = ($value == $fillValue) ? 'selected="selected"' : '' ;
			$subOptions .= '<option '.$select.' value="'. $value->id .'">'.str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $value->level - 1).$value->name.'</option>' ;
		}
                $option = CHtml::dropDownList($formName, $fillValue, $data, $htmlOptions);
		return $option ;
	}

	public function selectByStaticMethod($formName, $fillValue)
	{
		$option = CHTML::dropDownList($formName, $fillValue, call_user_func_array($this->tempType, array()));	
                return $option;
	}
	
	public function checkboxByStaticMethod($formName, $fillValue)
	{
		$option = '';
		$fillValue = explode(',', $this->fillValue);
		
		foreach (call_user_func_array($this->tempType, array()) as $name => $displayName){
			$option .= CHTML::checkBox($formName, in_array($name, $fillValue), array('value' => $name)).' '.$displayName;
		}
		
		return $option;
	}
	
	public function innerRadio($formName, $fillValue, $htmlOptions, $extraAttr)
	{          
                $data = self::getInnerData($extraAttr);
                $option = CHtml::radioButtonList($formName, $fillValue, $data, array('separator' => '&nbsp', 'labelOptions' => array('class' => 'labelForRadio')));
		return $option ;
	}

	public function outsideRadio($formName, $fillValue, $htmlOptions, $extraAttr)
	{
                $data = self::getOutsideData($extraAttr);
                $option = CHtml::radioButtonList($formName, $fillValue, $data, $htmlOptions);
		return $option ;
	}

	public function innerCheckbox($formName, $fillValue, $htmlOptions, $extraAttr) {
                $data = self::getInnerData($extraAttr);
                $option = CHtml::checkBoxList($formName, $fillValue, $data);
		return $option ;
	}

	public function outsideCheckbox($formName, $value, $htmlOptions, $extraAttr)
	{
		$data = self::getOutsideData($extraAttr);
                $option = CHtml::checkBoxList($formName, $value, $data, $htmlOptions);
		return $option ;
	}

	public function password($formName, $fillValue)
	{
                $option = CHtml::passwordField($formName, $fillValue);
                $option .= '<tr><td width="20%"><label>确认密码</label></td><td>' . CHtml::passwordField('', '', array(
                    'class' => 'rePassword',
                    'label' => 'password',
                )) . '<td></td></tr>';
		return $option;
	}

	public function monthPicker($formName, $fillValue, $htmlOptions)
	{
		Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery/jquery.ui.datepicker.js');
                $option = CHtml::textField($formName, $fillValue, $htmlOptions);
		return $option ;
	}

	public function datePicker($formName, $fillValue, $htmlOptions)
	{
                Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery/jquery.ui.datepicker.js');
                $option = CHtml::textField($formName, $fillValue, $htmlOptions);
		return $option ;
	}

	public function provincePicker($formName, $fillValue)
	{               
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
							$(\'input[name="'.$formName.'"]\').val($("#province").find("option:selected").text() + "," + $("#city").find("option:selected").text())
                                                        
						})
					}); </script> ';

		$option = '<div class="ChinaArea">
						<select id="province" style="width: 100px;"></select>
						<select id="city" style="width: 100px;"></select>
					</div><td><input type="hidden" name='.$formName.' class="hometown" value="'.$fillValue.'"/></td>'.$suboption;
		return $option ;
	}
        
	public function postAttach($formName)
	{
                Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/uploadify/jquery.uploadify-3.1.js');  
                Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/uploadify/uploadify.css");
		if (preg_match('/\[(.*?)\]/', $formName, $match))
                {
                        $name = $match[1];
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

		$option = CHtml::fileField('file_upload_' . $name, '', array(
                    'id' => 'file_upload_' . $name,
                )) . '<div class="file_box" id="file_box_'. $name .'"></div>'.$suboption;
                return $option ;
	}

	public function uploadPic($formName, $fillValue)
	{
                $subOption = 	'<script src="/js/jquery/jquery.color.js" type="text/javascript"></script>
						<script src="/js/jquery/jquery.Jcrop.js" type="text/javascript"></script>
						<link rel="stylesheet" type="text/css" href="/css/jquery.Jcrop.css" />';
                         
                if (preg_match('/\[(.*?)\]/', $formName, $match))
                {
                        $name = $match[1];
                }
		if (isset($fillValue))
                {
			$option = '<label class="pictrueLoad"><img src="'.$fillValue.'"/></td>
                                   <td><button onclick="return false" class="uploadPic '.$name.'">上传图片</button></td>' . $subOption;
		}
                else
                {
                        $option = '<label class="pictrueLoad"></label><td><button onclick="return false" class="uploadPic '.$name.'">上传图片</button></td>' . $subOption;
		}

		return $option ;
	}

	public function checkMust($isMust, $name, $label)
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

	public function addRules($rules, $formName){
                
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
					$(\'input[name="'.$formName.'"]\').live("blur", function () {
						checkRules(this, '.$type.');
					})
				});
				</script>';
		}
		return $ruleJS;
	}

	public function isUDF($name, $category){
		return ($category == 'udf') ? 'form[udf_'.$name.']' : 'form['.$name.']' ;
	}

	public function getFillValue($name, $model, $defaultValue='')
        {
		$fillValue = isset($model->$name) ? $model->$name : null ;
		if (!$fillValue && $defaultValue){
			$fillValue = $defaultValue;
		}
		//自定义表单内容填充, pa_form_field表
		$cover = 'fieldNameCover'.$this->conditionId ;
                
		if (!$fillValue && isset($model->$cover)){
			$formValue = json_decode($model->$cover);
			$fillValue = isset($formValue->$name) ? $formValue->$name: null ;
		}
		return $fillValue;
	}
        
        //在数据库中获取对应的key值
	public function getCoverage($key=null)
	{     
                if ($key == 'type')
                {
                        $idName = 'fieldName'.$this->conditionId;
                        $fieldValue = $this->formField->$idName;
                        $type = PaField::model()->findByAttributes(array('name' => $fieldValue))->type;
                        $this->type = $type;
                        return $type;
                        //return $type;
                }
                else 
                {
                        $cover = 'fieldNameCover'.$this->conditionId ;
                        $obj = json_decode($this->formField->$cover);
                        
                        return isset($obj->$key) ? $obj->$key : null ;
                }
                
		
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

	public  function setEnv($subFormField)
	{
		$module = Yii::app()->homeUrl;
		$controller = Yii::app()->controller->id ;
		$action = Yii::app()->controller->action->id ;
                
		$condition2 = json_decode($subFormField->fieldNameCondition2);
		if ((isset($condition2->action) && $condition2->action==$action) && (isset($condition2->controller)  && $condition2->controller==$controller) &&  (isset($condition2->module) && $condition2->module==$module)){
                    if ($this->checkParameter($condition2->parameter)) 
                    {
                        return $this->conditionId = 2;
                    }   
		}
		$condition1 = json_decode($subFormField->fieldNameCondition1);
		if ((isset($condition1->action) && $condition1->action==$action) && (isset($condition1->controller)  && $condition1->controller==$controller) &&  (isset($condition1->module) && $condition1->module==$module)){	
		    if ($this->checkParameter($condition1->parameter))
                    {
                        return $this->conditionId = 1;
                    }
		}
		$condition0 = json_decode($subFormField->fieldNameCondition0);
		if ((isset($condition0->action) && $condition0->action==$action) && (isset($condition0->controller)  && $condition0->controller==$controller) &&  (isset($condition0->module) && $condition0->module==$module)){	
		    if ($this->checkParameter($condition0->parameter)) 
                    {
                        return $this->conditionId = 0;
                    }
		}
		return $this->conditionId = null;
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
		$cover = 'fieldNameCondition'.$id ;
		$obj = json_decode($formField->$cover);
		return isset($obj->$key) ? $obj->$key : null ;
	}
}