<div id="tabs">
<ul>                          
<li><a href="#addQuestionnaire">问卷表单</a></li>
</ul> 
    
 
<?php 
$this->renderPartial('application.views.callFormView', array(
    'fieldModel' => $fieldModel,
    'editModel' => $editQuestionnaireModel
));
?>   
</div>



        