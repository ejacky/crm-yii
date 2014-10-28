<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/crm.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/chosen.css" />
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-ui-1.8.22.custom.css' />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery/jquery-1.7.2.min.js" type="text/javascript"></script>
 	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery/chosen.jquery.js" type="text/javascript"></script>
 	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery/jquery.cookie.js" type="text/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery/jquery-ui-1.8.22.custom.min.js" type="text/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/crm.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery/jquery.form.js" type="text/javascript"></script>
	
	<script>
	$(function () {
	/*
	    function update() {
               $.ajax({
                   'url' : '/index.php/calendar/displayCalendar',
                   'timeout' : 1000,
                   'success' : function (data) {
                       if (data != '') {
                          alert(data); 
                       } 
                       window.setTimeout(update, 1000);
                   },
                   'error' : function () {
                       alert('error');
                   }
                   
               });
		}
		update();
		*/
	});
	</script>
	
<style type="text/css">
.file_box {
    background-color: #FFF;
    border-radius: 3px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.25);
    height: 203px;
    margin-bottom: 10px;
    overflow: auto;
    padding: 5px 10px;
    width: 350px;
    float:left;
}
</style>
</head>
<body>
<div class="container" id="page">
	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
		<div class="frontToEnd" style="float:right; margin-right:50px; margin-top:-30px;">	
			<span id="notice"></span>
			<a href="/index.php/staff/addStaff">我的资料</a>
			<span style="width: 10px;"> | </span>
			<a href="/admin.php">进入后台</a>
                        <span style="width: 10px;"> | </span>  
                        <a href="/admin.php/login/logout">登出</a>
                        <span style="width: 10px;"> | </span>
                        <a href="#"><?php echo YII::app()->user->getName(); ?></a>
		</div>
	</div><!-- header -->
	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'文件管理', 'url'=>array('/file/index'),'active'=>Yii::app()->controller->id=='file'),
				array('label'=>'客户管理', 'url'=>array('/client/index'),'active'=>Yii::app()->controller->id=='client'),
				array('label'=>'联系人管理', 'url'=>array('/contact/index'),'active'=>Yii::app()->controller->id=='contact'),	
                                array('label'=>'课程管理', 'url'=>array('/course/index'),'active'=>Yii::app()->controller->id=='course'),
//				array('label'=>'客户沟通情况管理', 'url'=>array('/account/crmTaskBrowse'),'active'=>Yii::app()->controller->id=='account'),
				array('label'=>'工作日历', 'url'=>array('/calendar/index'),'active'=>Yii::app()->controller->id=='calendar'),
			),
		)); ?>
	</div><!-- mainmenu -->
	<select onchange="selectToUrl(this.options[this.options.selectedIndex].value)" style="width: 100px; float:right;margin-top:-24px;margin-right:3px;">
		<option ="">选择管理页面</option>
		<option value="/index.php/course/lecturerIndex">联系记录管理</option>
		<option value="/index.php/course/lecturerIndex">讲师管理</option>
		<option value="/index.php/course/lecturerIndex">学员管理</option>
	</select>
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>
	<?php echo $content; ?>
	<div class="clear"></div>
	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by 上海朋朋网络科技有限公司.<br/>
		All Rights Reserved.<br/>		
	</div><!-- footer -->
</div><!-- page -->
</body>
</html>