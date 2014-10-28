<?php 
Yii::import('application.views.form.formTemplate', true);
echo formTemplate::$allTemplate ;
?>
<div id="tabs">
<ul>                          
<li><a href="#addCourse">课程表单</a></li>
</ul> 
<?php
$this->renderPartial('application.views.callFormView', array(
    'editModel' => $editModel,
    'fieldModel' => $fieldModel,
    'formName' => 'PaForm',
));
?>   
</div>
