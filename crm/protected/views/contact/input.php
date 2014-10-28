<style>
.basicInfo,.moreInfo { border: 1px solid #C9E0ED; padding: 2px; margin-bottom: 5px;}
label { padding: 2px;}
input { padding: 2px; margin-left: 4px;}
</style>

<?php echo CHtml::beginForm(); ?>
<?php echo CHtml::errorSummary($model); ?>

<div class="basicInfo">
<?php echo CHtml::activeLabel($model,'公司名称:'); ?> <?php echo CHtml::activeLabel($model,$model->company->name); ?>
<?php echo CHtml::activeLabel($model,'员工姓名:'); ?> <?php echo CHtml::activeLabel($model,$model->name); ?>
<?php echo CHtml::activeLabel($model,'员工电话:'); ?><?php echo CHtml::activeLabel($model,$model->phone); ?>
<?php echo CHtml::activeLabel($model,'员工邮箱:'); ?><?php echo CHtml::activeLabel($model,$model->email); ?>

</div>

<div class="moreInfo">
<?php echo CHtml::activeDropdownlist($model,'task_id',CHtml::listData(CrmTask::model()->findAll(),'id','name'),array()); ?>
<?php echo CHtml::activeLabel($model,'计划量'); ?><?php echo CHtml::activeTextField($model,'plan'); ?>
<?php echo CHtml::activeLabel($model,'完成量'); ?><?php echo CHtml::activeTextField($model,'finish'); ?>
</div>

<div id="rowSubmit">
<?php echo CHtml::submitButton('保存'); ?> <?php echo CHtml::resetButton('重置'); ?>
</div>

<?php echo CHtml::endForm(); ?>
