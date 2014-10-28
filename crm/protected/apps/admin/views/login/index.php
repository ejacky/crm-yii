<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<style>
body {background: url("/images/bg.jpg") no-repeat scroll 200px 0 #63a8f5}
#center {margin-top: 300px; margin-left: 600px; }
image {margin-left: 20px;}
input {padding: 2px; margin:2px; }
</style>

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

</head>
<body>
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
	<div id="down">
		 </div>
	</div>
</body>
</html>