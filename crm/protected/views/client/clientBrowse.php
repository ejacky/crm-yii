<script>
$(function () {

   $('#companyHistory_type').change(function () {
       var companyHistoryId;
       var companyHistoryType;

       companyHistoryId  = <?php echo $clientId;?>;
       companyHistoryType = $(this).val();
       $.ajax({
           type : 'POST',
           data : {
               'clientId':companyHistoryId,
               'companyHistoryType':companyHistoryType
           },
           url : '/index.php/client/showHistoryAjax',
           success: function (data) {
              $('.accountInfo').html(data);
           },
           error: function () {
               alert('error');
           }
       });
   });
         var initData = '';
//       initData = <?php //echo $initHtml; ?>
//       if (typeof initData != 'undefined' && initData != '') {
//               $('.accountInfo').html(initData);
//       }
});
</script>


<div class="basicInfo">
<p>公司基本信息</p>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$detailCompanyModel,
	'attributes'=>array(
	    'name',
            'phone',
            'email',
	),
)); ?>
<?php echo CHtml::link('编辑公司信息', $this->createUrl('/client/editClient',array('clientId'=>$clientId))); ?> 
</div>

<div id="search">
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'companyHistory_id',
));?>

<?php echo $form->labelEx(new CompanyHistory, '按修改状态'); ?>
<?php echo $form->dropdownList(new CompanyHistory,
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

