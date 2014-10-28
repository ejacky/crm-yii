<div id="tabs">
	<ul><li><a href="#setForm">新建字段</a></li></ul><br/>
<?php echo formTemplate::$allTemplate ; ?>
<div id="createForm">
<?php
$form=$this->beginWidget('CActiveForm',array(
	'id' => 'form',
	'htmlOptions' => array(
		'class' => 'form',
	),
));

//$formView = new FetchSingleInputHtml($model);


//foreach pa_form_field 中的字段
//$subFormField : 每个field对象

foreach ($formFields as $subFormField)
{
        $formView = new NewInputUpdate($subFormField, $model);// refactory
	$id = $formView->setEnv($subFormField);//返回匹配的字段id
	$idName = 'field_id'.$id;
        //foreach pa_field 中的字段
	foreach ($fields as $value) 
        {   
		if ($value->id == $subFormField->$idName)  //判断 pa_field 中的 id值 与pa_form_field 中的field_id~值
                {
			$field = $value;    //若相等，则将该pa_field 中的该对象赋值给 $field
		}
	}
        
        $type = $field->type;     //获取 pa_field 中的该字段的type值
        if ($subFormField->$idName != 0) 
        {
            echo "<div class='",$formView->getCoverage($subFormField, 'name'),"'>", "<table>"; //获取name所对应的覆盖值
	    echo $formView->$type($subFormField); //返回该字段对应的html
	    echo "</table>","</div>";
        }
        else 
        {
            echo '';
        }
	
}
?>

<table><tr><td width="20%"></td><td><input type="submit" value="提交" id="saveForm" class="saveForm"></td></tr></table>
<?php  $this->endWidget(); ?>	 
</div>
</div>