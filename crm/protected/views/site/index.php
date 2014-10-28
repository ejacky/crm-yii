<?php $this->pageTitle=Yii::app()->name; ?>
<script>
$(function () {
	$("body").keydown(function (event) {
		Code = (event.keyCode)?event.keyCode:event.charCode;
		if (Code == 13)
		{
		    $("#login-form").submit();
		}
		});
	
});

function submitForm()
{
	document.forms[0].submit();
}
function resetForm()
{
	document.forms[0].reset();
}
</script>
<div id="login">
	<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>	
	     <div id="top">
		 </div>
		 <div id="center">
		      <div id="center_left">				 
		      </div>
			  <div id="center_middle">
			       <div id="user">用 户
			         <?php echo $form->textField($model,'username'); ?><?php echo $form->error($model,'username'); ?>
			       </div>
				   <div id="password">密   码
				     <?php echo $form->passwordField($model,'password'); ?><?php echo $form->error($model,'password'); ?>
				   </div>						
				   <div id="btn"><a href="javascript:submitForm()">登录</a></div>
			  
			  </div>
			  <div id="center_right"></div>		 
		 </div>
	<?php $this->endWidget(); ?>	 
	<div id="down"></div>
</div>