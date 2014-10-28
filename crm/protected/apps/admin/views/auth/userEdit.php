<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.cookie.js"); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.hotkeys.js"); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.jstree.js"); ?>

<script type="text/javascript">
$(function () {
	selectDepartment = function(id)
	{
		$('#departmentId').val(id);
		if (departmentPositionInfo[id] != undefined)
		{
			$('#positionCheckbox').html('');
			for (i in departmentPositionInfo[id])
			{
				$('#positionCheckbox').html($('#positionCheckbox').html() + '<input name="position" type="radio" value="'+departmentPositionInfo[id][i]+'" /> '+departmentPositionInfo[id][i]+'<br />');
			}
		}
		else
		{
			$('#positionCheckbox').html('');
		}
	}

	selectRole = function(roleId)
	{
		if ($('#role' + roleId).attr('checked'))
		{
			for (i in roleTaskIds[roleId])
			{
				$('#task'+ roleTaskIds[roleId][i]).attr('checked', 'checked');
			}
		}
		else
		{
			$('input[id^=task]').each(function(){
				$(this).attr('checked', '');
			})
			$('input[id^=role]').each(function(){
				if ($(this).attr('checked'))
				{
					selectRole($(this).attr('id').match(/\d+$/));
				}
			})
		}
	}

	// 每个部门的职位信息
	departmentPositionInfo = <?php echo $departmentPositionInfo ?>;
	//每个权限组所拥有的权限
	roleTaskIds = <?php echo $roleTaskIds ?>;
	
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
		// 显示部门信息
		"json_data" : 
			<?php echo $departmentData ?>
		,
		"ui" : { "initially_select" : [ "department<?php //echo $user ?>" ] },
		"plugins" : [ "themes", "json_data", "ui", "types" ]
	})
	.bind("select_node.jstree", function (e, data) { selectDepartment(jQuery.data(data.rslt.obj[0], "id")); })
});

</script>

<div class="form_title">
<h3>用户信息设置</h3>
<h4>通过这里可以创建用户的部门，职位，权限等</h4>
</div>
<br/>
<div class="error_summary" style="display:<?php if($error == null) echo 'none'; ?>">
<p>请更正下列输入错误:</p>
<ul>
<li><?php echo $error; ?>.</li>
</ul></div>

<div class="form1">
<form action="/admin.php/auth/<?php echo $type == 'edit' ? 'userEdit' : 'userCreate' ?>" method="post" class="form">
	<?php if ($type == 'edit') : ?>
	<input type="hidden" name="id" value="<?php echo $departmentModel->id ?>" />
	<?php endif; ?>
	<input type="hidden" id="departmentId" name="departmentId" value="" />
	<table>
		<?php if ($type == 'create') : ?>
	<tr>
	    <th> 选择用户：</th>
	    <td style="width:400px;">
			<select name="userId">
				<option value="0"></option>
				<?php foreach ($users as $user) : ?>
				<option value="<?php echo $user->id ?>"><?php echo $user->username ?></option>
				<?php endforeach; ?>
			</select>
		</td>
	    <td><span>请输入分类名称</span></td>
	</tr>
	<?php else : ?>
	<tr>
		<th>用户名：</th>
		<td><?php echo $user->username ?></td>
	</tr>
	<?php endif; ?>
	<tr>
	    <th> 选择部门：</th>
	    <td>
			<div id="departmentTree"></div>
		</td>
	    <td><span>请输入分类名称</span></td>
	</tr>
	<tr>
	    <th>职位选择：</th>
	    <td id="positionCheckbox"></td>
	    <td><span>请输入分类名称</span></td>
	</tr>
	<tr>
	    <th>权限选择：</th>
	    <td>
			<div>权限组选择：</div>
			<div>
				<?php foreach ($roles as $role) : ?>
				<input type="checkbox" name="role[<?php echo $role->id ?>]" id="role<?php echo $role->id ?>" onchange="selectRole('<?php echo $role->id ?>')" /> <?php echo $role->display_name ?>&nbsp;&nbsp;&nbsp;&nbsp;
				<?php endforeach; ?>
			</div>
			<p>
			<div>权限选择：</div>
			<div>
				<?php foreach ($tasks as $task) : ?>
				<input type="checkbox" name="task[<?php echo $task->id ?>]" id="task<?php echo $task->id ?>" /> <?php echo $task->display_name ?>&nbsp;&nbsp;&nbsp;&nbsp;
				<?php endforeach; ?>
			</div>
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
