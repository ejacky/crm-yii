<style>
.basicInfo,.moreInfo { border: 1px solid #C9E0ED; padding: 2px; margin-bottom: 5px;}
.moreInfo {display: none; }
label { padding: 2px;}
input { padding: 2px; margin-left: 4px;}
</style>

<?php echo CHtml::beginForm(); ?>
<?php echo CHtml::errorSummary($model); ?>

<div>
<a href="javascript:void(0)">添加任务</a>
</div>


<div class="basicInfo">
<?php echo CHtml::activeLabel($model,'公司名称:'); ?> <?php echo CHtml::activeLabel($model,$model->company->name); ?>
<?php echo CHtml::activeLabel($model,'员工姓名:'); ?> <?php echo CHtml::activeLabel($model,$model->name); ?>
<?php echo CHtml::activeLabel($model,'员工电话:'); ?><?php echo CHtml::activeLabel($model,$model->phone); ?>
<?php echo CHtml::activeLabel($model,'员工邮箱:'); ?><?php echo CHtml::activeLabel($model,$model->email); ?>

</div>

<div class="moreInfo">

</div>

<div id="rowSubmit">
<?php echo CHtml::link('编辑', '/admin.php/clientEmployees/edit/?employee_id='.$model->id); ?> <?php echo CHtml::link('删除 ','/admin.php/clientEmployees/delete/?employee_id='.$model->id); ?>
</div>

<?php echo CHtml::endForm(); ?>


<div>
<a href="javascript:void(0)">添加任务</a>
</div>


<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
        array('name'=>'company','value'=>'$data->company->name'),
		'name',
        'phone',
        'email',

	),
)); ?>

<div id="rowSubmit">
<?php echo CHtml::link('编辑公司信息', '/admin.php/clientCompany/edit/?company_id='.$model->id); ?> <?php echo CHtml::link('删除 ','/admin.php/clientCompany/delete/?company_id='.$model->id); ?>
</div>
