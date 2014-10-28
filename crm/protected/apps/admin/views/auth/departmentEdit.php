<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.cookie.js"); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.hotkeys.js"); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.jstree.js"); ?>

<?php if (Yii::app()->user->hasFlash('pageInfo')) : ?>
<?php $this->renderPartial('application.views.page.infoSummary', array('pageInfo'=>Yii::app()->user->getFlash('pageInfo'))); ?>
<?php endif; ?>

<?php if (Yii::app()->user->hasFlash('errorInfo')) : ?>
<?php $this->renderPartial('application.views.page.errorSummary', array('errorInfo'=>Yii::app()->user->getFlash('errorInfo'))); ?>
<?php endif; ?>

<script type="text/javascript">


$(function () {
	selectDepartment = function(id, name)
	{
		$('#departmentId').val(id);
		$('#departmentName').val(name);
		if (departmentTitleInfo[id] != undefined)
		{
			$('.form input[type=checkbox]').attr('checked', '');
			for (i in departmentTitleInfo[id])
			{
				$('.form input[value='+departmentTitleInfo[id][i]+']').attr('checked', 'checked');
			}
		}
		else
		{
			$('.form input[type=checkbox]').attr('checked', '');
		}
	}

	departmentTitleInfo = <?php echo $allDepartmentTitleInfo ?>;
	
	$("#departmentTree").jstree({
		"types" : {
			"valid_children" : [ "none" ]
		},
		"json_data" : 
			<?php echo $departmentData ?>
		,
		"ui" : { "initially_select" : [ "department<?php echo $_GET['id'] ?>" ] },
		"plugins" : [ "themes", "json_data", "ui", "types" ]
	}).bind("select_node.jstree", function (e, data) { selectDepartment(jQuery.data(data.rslt.obj[0], "id"), jQuery.data(data.rslt.obj[0], "name")); });
});

</script>


<div class="form_title">
<h3>部门和职位创建</h3>
<h4>通过这里可以创建部门和职位</h4>
</div>



<div class="form1">
<form action="/admin.php/auth/<?php echo $type == 'edit' ? 'departmentEdit' : 'departmentCreate' ?>" method="post" class="form">
	<?php if ($type == 'edit') : ?>
	<input type="hidden" name="id" value="<?php echo $departmentModel->id ?>" />
	<?php endif; ?>
	<input type="hidden" id="departmentId" name="departmentId" value="" />
	<table>

	<tr>
		<th><em>*</em> 部门选择：</th>
		<td style="width:200px;"><div id="departmentTree"></div></td>
		<td><span>请输入分类名称</span></td>
	</tr>
	<tr>
	    <th><em>*</em> 部门名称：</th>
	    <td><input type="text" name="categoryName" id="departmentName" rule="checkForCatalog" value="<?php echo $type == 'edit' ? $departmentModel->name : '' ?>"/></td>
	    <td><span>请输入部门名称</span></td>
	</tr>
	<tr>
		<th><em>*</em> 职位选择：</th>
		<td>
			<?php foreach ($titleInfo as $title): ?>
			<?php if ($type == 'edit') : ?>
				<?php
				$checked = '';
				foreach ($chenckedDepartmentTitleInfo as $checkedTitle)
				{
					if ($checkedTitle->title == $title)
					{
						$checked = 'checked="checked"';
					}
				}
				?>
				<input type="checkbox" name="title[]" <?php echo $checked ?> value="<?php echo $title ?>" /> <?php echo $title ?><br />
			<?php else : ?>
				<input type="checkbox" name="title[]" value="<?php echo $title ?>" /> <?php echo $title ?><br />
			<?php endif; ?>
			<?php endforeach; ?>
		</td>
		<td><span>请输入分类名称</span></td>
	</tr>
	<tr>
	    <th></th>
	    <td><input type="submit" value="保存" name="submit1"/></td>
	</tr>
	</table>
</form>
</div>
