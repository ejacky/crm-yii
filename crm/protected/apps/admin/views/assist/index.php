<div id="tabs">
<ul>                          
<li><a href="#setForm">设置表单</a></li>
</ul>    
<?php
Yii::import('application.views.form.formTemplate', true);
echo formTemplate::$allTemplate ;

$this->renderPartial('application.views.callFormView', array(
    'editModel' => $editModel,
    'fieldModel' => $fieldModel,
));
?>                 
</div>
