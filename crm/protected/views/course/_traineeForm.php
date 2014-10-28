<div id="tabs">
<ul>                          
<li><a href="#addCourse">学员表单</a></li>
</ul>    
 
<?php 
$this->renderPartial('application.views.callFormView', array(
    'fieldModel' => $fieldModel,
    'editModel' => $editTraineeModel
));
?>   
</div>



        