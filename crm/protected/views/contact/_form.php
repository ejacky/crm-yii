<div id="tabs">
<ul>                          
<li><a href="#addCourse">创建表单</a></li>
</ul>   
 
<div id="createForm">
<?php $form=$this->beginWidget('CActiveForm',array(
    'htmlOptions' => array(
        'class' => 'form',
    ),
)); ?>
   
 <?php 
$formView = new FormView($editModel);
foreach ($fieldModel as $sub)
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
		case 'addOption': echo $formView->getaddOption( $sub->name, $sub->label ) ; break;
		case 'uploadPic': echo $formView->uploadPic( $sub->name, $sub->label ) ; break;
		case 'postAttach': echo $formView->postAttach( $sub->name, $sub->label ) ; break;
		case 'provincePicker': echo $formView->provincePicker( $sub->label ) ; break;
		case 'datePicker': echo $formView->datePicker( $sub ) ; break;
		case 'exCheckbox': echo $formView->exCheckbox( $sub, Property::model()->find('name=:name', array(':name'=>'cms-title'))->value ) ;  break;
	}
        echo "</table>";
        echo "</div>";
}
?>   
    <button class="saveForm" style="margin-left:25px;">提交</button>
<?php  $this->endWidget(); ?> 
        
</div>             
</div>





        

