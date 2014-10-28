<?php 
Yii::import('application.views.form.formTemplate', true);
echo formTemplate::$allTemplate ;
?>

<?php $form=$this->beginWidget('CActiveForm',array(
    'id' => 'company-form',
)); ?>

<div id="tabs">
<ul>
<?php foreach ($groupList as $subList) : ?>
<li><a href="#<?php echo $subList->groupName;?>"><?php echo $subList->groupName;?></a></li>
<?php endforeach; ?>
</ul>
<?php echo $form->errorSummary($model); ?>
<?php foreach ($groupList as $subList) : ?>
 <div id="<?php echo $subList->groupName;?>">
<?php

$formView = new FormView($model);
foreach ($model1 as $sub)
{
	echo "<div class='".$sub->name."'>";
    echo "<table>";
	switch ($sub->type)
	{
		case 'radio': echo $formView->radio( $sub ) ;  break;
		case 'hidden':
		case 'file':
		case 'password': echo $formView->password( $sub ); break;
		case 'text':  echo $formView->getText( $sub ) ;  break;
		case 'select': echo $formView->getSelect( $sub ) ;  break;
		case 'textarea': echo $formView->getTextarea( $sub ) ; break;
		case 'exSelect': echo $formView->getexSelect( $sub, FormHandler::getAllDataObject('PaForm') ) ;  break;
		case 'addOption': echo $formView->getaddOption( $sub->name, $sub->label ) ; break;
		case 'uploadPic': echo $formView->uploadPic( $sub->name, $sub->label ) ;  break;
		case 'postAttach': echo $formView->postAttach( $sub->name, $sub->label ) ; break;
		case 'provincePicker': echo $formView->provincePicker( $sub->label ) ; break;
		case 'datePicker': echo $formView->datePicker( $sub ) ; break;
	}
    echo "</table>";
    echo "</div>";
}
?>
<table><tr><td width="20%"></td><td><input type="submit" value="提交" id="saveForm1" onclick="return false;"></td></tr></table>
</div>
<?php endforeach; ?>
</div>
<?php  $this->endWidget(); ?>
<script>
$(function(){
	var name = 'input[label="username"],input[label="name"],input[label="ename"],input[label="birthday"],input[name="form[sex]"], select[name="form[province]"], input[name="form[IDCard]"], input[name="form[EntryTime]"], select[name="form[educational]"], input[name="form[GraduateSchool]"], input[name="form[GraduationYear]"], select[name="form[nation]"]' 
	FillData(name);
})
function FillData(name){
	name = name.split(',');
	for(var key in name){
		$(name[key]).closest('td').html($(name[key]).val())
	}
}
</script>