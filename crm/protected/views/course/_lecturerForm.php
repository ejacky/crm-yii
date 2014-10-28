
<div id="tabs">
<ul>                          
<li><a href="#addCourse">讲师表单</a></li>
</ul> 
<?php 
$this->renderPartial('application.views.callFormView', array(
    'fieldModel' => $fieldModel,
    'editModel' => $editTrainLecturerModel
));
?>  
<?php 
Yii::import('application.views.form.formTemplate', true);
echo formTemplate::$allTemplate ;
?>
</div>





        