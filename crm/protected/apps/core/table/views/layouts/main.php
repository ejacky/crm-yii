<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<!-- JQuery -->
 	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery/jquery-1.7.2.min.js" type="text/javascript"></script>
 	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/crm.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/crm.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/chosen.css" />
	<link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-ui-1.8.22.custom.css' />
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery/jquery.cookie.js" type="text/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery/jquery-ui-1.8.22.custom.min.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery/jquery.form.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery/chosen.jquery.js" type="text/javascript"></script>
</head>
<body>
<div class="container" id="page">
	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>		
		<div class="frontToEnd" style="float:right; margin-right:50px; margin-top:-30px;">
		<a href="/index.php">返回前台</a><span>|</span>
		<a href="<?php echo Yii::app()->createUrl('login/logout'); ?>">登出</a>
		<span style="width: 10px;"> | </span>
         <a href="#"><?php echo YII::app()->user->getName(); ?></a>
	    </div>
	</div><!-- header -->
	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'程序调试', 'url'=>array('/assist/index'),'active'=>Yii::app()->controller->id=='assist'),
				array('label'=>'部门和职位管理', 'url'=>array('/organization/departmentList'),'active'=>Yii::app()->controller->id=='organization'),
				array('label'=>'权限管理', 'url'=>array('/authority/roleList'),'active'=>Yii::app()->controller->id=='authority'),
				array('label'=>'设置表单', 'url'=>array('/customForm/paFormList'),'active'=>Yii::app()->controller->id=='customForm'),
				array('label'=>'设置表格', 'url'=>array('/tableSet/index'),'active'=>Yii::app()->controller->id=='tableSet'),
				array('label'=>'员工管理', 'url'=>array('/staff/index'),'active'=>Yii::app()->controller->id=='staff'),
				array('label'=>'登录', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>
	<?php echo $content; ?>
	<div class="clear"></div>
	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by 朋朋网络科技有限公司.<br/>
		All Rights Reserved.<br/>		
	</div><!-- footer -->
</div><!-- page -->
</body>
</html>