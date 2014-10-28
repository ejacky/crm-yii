<?php echo formTemplate::$allTemplate ; ?>
<div id="tabs">
<ul>
<?php $groupList = array(0=>'默认',1=>'情况一',2=>'情况二',3=>'情况三')?>
<?php foreach ($groupList as $key=>$val) : ?>
<li><a href="#<?php echo $val;?>"><?php echo $val;?></a></li>
<?php endforeach; ?>
</ul>
<?php foreach ($groupList as $key=>$val) : ?>
<div id="<?php echo $val;?>" class="<?php echo 'condition'.$key;?>">
<?php
$form=$this->beginWidget('CActiveForm',array(
	'id' => 'customform',
	'htmlOptions' => array(
		'class' => 'form',
	),
));


//need to refactory

$formView = new FetchSingleInputHtml($model);
if ($key==1 || $key==2 || $key==3){
	echo '<input type="hidden" name="condition[index]" value="'.($key-1).'">';
	echo "<div class='parameter'>", "<table>";
	echo '<tbody><tr><td width="20%"><label>模块</label></td><td>
			<select name="condition[module]">
			<option value="/index.php">前台</option>
			<option value="/admin.php">后台</option>
			<option value="null">不使用</option>
			</select></td></tr></tbody>';
	echo "</table>","</div>";
	
	echo "<div class='parameter'>", "<table>";
	echo '<tbody><tr><td width="20%"><label>条件controller</label></td><td><input value="'.$formView->getCondition($model, 'controller', $key-1).'" type="text" name="condition[controller]"></td></tr></tbody>';
	echo "</table>","</div>";
	
	echo "<div class='parameter'>", "<table>";
	echo '<tbody><tr><td width="20%"><label>条件action</label></td><td><input value="'.$formView->getCondition($model, 'action', $key-1).'" type="text" name="condition[action]"></td></tr></tbody>';
	echo "</table>","</div>";
	
	echo "<div class='parameter' style='border-bottom: 1px solid #C9E0ED;'>", "<table>";
	echo '<tbody><tr><td width="20%"><label>条件parameter</label></td><td><input value="'.$formView->getCondition($model, 'parameter', $key-1).'" type="text" name="condition[parameter]"></td></tr></tbody>';
	echo "</table>","</div><br/>";
	
}
$idX = ($key)?($key-1):null;
foreach ($formFields as $subFormField)
{       
//        $formView = new NewInput($model);
	$id = $formView->setEnv($subFormField);
	$idName = 'field_id'.$id;
	foreach ($fields as $value) {
		if ($value->id==$subFormField->$idName){
			$field = $value;
		}
	}
	echo "<div class='",$formView->getCoverage($subFormField, 'name'),"'>", "<table>";
	$type = $field->type;
        
	echo $formView->$type($subFormField);
	echo "</table>","</div>";
}
?>
<table><tr><td width="20%"></td><td><input type="submit" value="提交" id="saveForm" class="saveForm"></td></tr></table>
<?php  $this->endWidget(); ?>	 
</div>
<?php endforeach; ?>
</div>
