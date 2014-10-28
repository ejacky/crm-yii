<!-- <a href="/admin.php/clientCompany/addCustomForm">自定义表单</a>|<a href="/admin.php/clientCompany/addNewInfo">自定义表单2</a>  -->
<?php echo $this->renderPartial('_form', array(
    'model' => $model,
    'editModel' => null,
    'fieldModel' => $fieldModel,
    'groupList' => $groupList,
    ));