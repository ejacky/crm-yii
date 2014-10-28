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
		case 'text':  echo $formView->getText( $sub ) ;  break;
		case 'postAttach': echo $formView->postAttach( $sub->name, $sub->label ) ; break;
	}
    echo "</table>";
    echo "</div>";
}
?>
<table><tr><td width="20%"></td><td><input type="submit" value="提交" id="saveForm"></td></tr></table>
</div>
<?php endforeach; ?>
</div>
<?php  $this->endWidget(); ?>

<script>
$(function(){
	<?php
	if ($model){
		foreach ($model as $value) {
			if ($value->key=='fileSize'){
				echo '$(\'input[name="form[fileSize]"]\').val("'.$value->value.'");';
			}
			if ($value->key=='fileType'){
				echo '$(\'input[name="form[fileType]"]\').val("'.$value->value.'")';
			}
		}
	}
	?>
})
</script>