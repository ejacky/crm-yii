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
Yii::import('application.views.form.formTemplate', true);
echo formTemplate::$allTemplate ;
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
		case 'provincePicker': echo $formView->provincePicker( $sub->label ) ; $city = explode(',',$model->hometown); break;
		case 'datePicker': echo $formView->datePicker( $sub ) ; break;
		case 'monthPicker': echo $formView->monthPicker( $sub ) ; break;
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
	var loc = new Location();

	$(".ChinaArea").jChinaArea({
		<?php echo !empty($city[0]) ?  "s1: '$city[0]'," : '' ;?>
		<?php echo !empty($city[0]) ?  "s2: '$city[1]'," : '' ;?>
	})
})
</script>