<?php $form=$this->beginWidget('CActiveForm',array(
    'htmlOptions' => array(
        'class' => 'form'
    ),
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
$formView = new FormView($editModel);
foreach ($fieldModel as $sub)
{
        if ($sub->category == $subList->groupName)
        {
	echo "<div class='".$sub->name."'>";
        echo "<table>";
	switch ($sub->type)
	{
		case 'radio': echo $formView->radio( $sub ) ;  break;
		case 'hidden':
		case 'file':
		case 'password':
		case 'text':  echo $formView->getText( $sub ) ;  break;
		case 'select': echo $formView->getSelect( $sub ) ;  break;
		case 'textarea': echo $formView->getTextarea( $sub ) ; break;
		case 'exSelect': echo $formView->getexSelect( $sub, FormHandler::getAllDataObject('PaForm') ) ;  break;
		case 'addOptions': echo $formView->getaddOptions( $sub->name, $sub->label ) ; break;
		case 'uploadPic': echo $formView->uploadPic( $sub->name, $sub->label ) ; break;
		case 'postAttach': echo $formView->postAttach( $sub->name, $sub->label ) ; break;
		case 'provincePicker': echo $formView->provincePicker( $sub->label ) ; break;
		case 'datePicker': echo $formView->datePicker( $sub ) ; break;
		case 'exCheckbox': echo $formView->exCheckbox( $sub, Property::model()->find('name=:name', array(':name'=>'cms-title'))->value ) ;  break;
	}
        echo "</table>";
        echo "</div>";
        }
}
?>     
<table><tr><td width="20%"></td><td><input type="submit" value="提交" id="saveForm" class="saveForm"></td></tr></table>
</div> 
<?php endforeach; ?>          
     
</div>

<?php  $this->endWidget(); ?> 
