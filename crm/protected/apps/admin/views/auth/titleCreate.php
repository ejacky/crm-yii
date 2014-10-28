<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/my.css"); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/my.js"); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.cookie.js"); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.hotkeys.js"); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.jstree.js"); ?>

<script type="text/javascript">


$(function () {
	selectDepartment = function(id)
	{
		$('#departmentId').val(id);
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

	departmentTitleInfo = <?php echo $departmentTitleInfo ?>;
	
	$("#departmentTree").jstree({
		"types" : {
			"valid_children" : [ "none" ],
			"types" : {
				"tail" : {
					"icon" : { 
						"image" : "/js/themes/default/drive.png" 
					},
					"valid_children" : [ "default" ],
					"max_depth" : 3
				}
			}
		},
		"json_data" : 
			<?php echo $departmentData ?>
		,
		"plugins" : [ "themes", "json_data", "ui", "types" ]
	}).bind("select_node.jstree", function (e, data) { selectDepartment(jQuery.data(data.rslt.obj[0], "id")); });
});

</script>


<div class="form_title">
<h3>创建职位信息</h3>
</div>
<br/>
<div class="error_summary" style="display:<?php if($error == null) echo 'none'; ?>">
<p>请更正下列输入错误:</p>
<ul>
<li><?php echo $error; ?>.</li>
</ul></div>

<div class="form1">
<form action="/admin.php/auth/<?php echo $type == 'edit' ? 'titleEdit' : 'titleCreate' ?>" method="post" class="form">
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
		<th><em>*</em> 职位选择：</th>
		<td style="width:400px;">
			<?php foreach ($titleInfo as $title): ?>
			<input type="checkbox" name="title[]" value="<?php echo $title ?>" /> <?php echo $title ?><br />
			<?php endforeach; ?>
		</td>
		<td><span>请输入分类名称</span></td>
	</tr>
	<tr>
		<th></th>
		<td><input type="submit" value="保存" /></td>
	</tr>
	</table>
</form>
</div>
<br/>

