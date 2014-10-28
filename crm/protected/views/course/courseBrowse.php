<script>
$(function () {

   $('#courseHistory_type').change(function () {
       var trainCourseHistoryId;
       var trainCourseHistoryType;
       

       trainCourseHistoryId  = <?php echo $courseId;?>;
       courseHistoryType = $(this).val();
       
       $.ajax({
           type : 'POST',
           data : {
               'courseId':trainCourseHistoryId,
               'courseHistoryType':courseHistoryType
           },
           url : '/index.php/course/showHistoryAjax',
           success: function (data) {
              $('.accountInfo').html(data);
           },
           error: function () {
               alert('error');
           }
       });
   });
 //        var initData = '';
//       initData = <?php //echo $initHtml; ?>
//       if (typeof initData != 'undefined' && initData != '') {
//               $('.accountInfo').html(initData);
//       }
});
</script>


<div class="basicInfo">
<p>公司基本信息</p>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$detailCourseModel,
	'attributes'=>array(
	    'courseName',

	),
)); ?>
<?php echo CHtml::link('编辑公司信息', $this->createUrl('/course/editClient',array('courseId'=>$courseId))); ?> 
</div>


<div style="overflow:auto;overflow-y:hidden;">
	<div id="tableContent"></div>
</div>
<script>
displayTable('<?php echo $name ?>');
</script>


<div id="search">
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'trainCourseHistory_id',
));?>

<?php echo $form->labelEx(new CourseHistory, '按修改状态'); ?>
<?php echo $form->dropdownList(new CourseHistory,
        'type',
        array('all'=>'所有', 'create'=>'创建客户', 'addTask'=>'任务', 'edit'=>'修改'),
        array()
        ); ?>
<?php $this->endWidget(); ?>
</div>

<div class="accountInfo">
<p>最新动态</p>
<?php echo $initHtml; ?>

<?php 
$this->widget('CLinkPager', array(
    'pages' => $pages, 
));
?>
</div>

