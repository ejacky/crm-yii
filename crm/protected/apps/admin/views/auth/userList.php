<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/styles.css" />

<?php if (Yii::app()->user->hasFlash('pageInfo')) : ?>
<?php $this->renderPartial('application.views.page.infoSummary', array('pageInfo'=>Yii::app()->user->getFlash('pageInfo'))); ?>
<?php endif; ?>
<?php if (Yii::app()->user->hasFlash('errorInfo')) : ?>
<?php $this->renderPartial('application.views.page.errorSummary', array('errorInfo'=>Yii::app()->user->getFlash('errorInfo'))); ?>
<?php endif; ?>

<table id="portal-columns">
	<tbody>
		<tr>
				<td id="portal-column-content">
<div class="grid-view" id="is-visible-grid">
	<table class="items">
		<thead>
			<tr>
				<th id="is-visible-grid_c0">用户名</th>
				<th id="is-visible-grid_c0">部门和职位</th>
				<th id="is-visible-grid_c6" class="button-column" style="width: 100px">操作</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($userDepartmentPositionInfo as $key => $user):?>
			<tr class="odd" class="even">
				<?php
				if ($user->user->username == $userDepartmentPositionInfo[$key-1]->user->username)
				{
					
				}
				else if ($user->user->username == $userDepartmentPositionInfo[$key+1]->user->username)
				{
					$usernameCount = 0;
					foreach ($userDepartmentPositionInfo as $info)
					{
						if ($info->user->username == $userDepartmentPositionInfo[$key]->user->username)
						{
							$usernameCount += 1;
						}
					}
					echo "<td rowspan='$usernameCount'>{$user->user->username}</td>";
				}
				else
				{
					echo "<td>{$user->user->username}</td>";
				}
				?>
				<td>
				<?php echo $user->department->full_name ?>：<?php echo $user->position ?>
				</td>
				<td class="button-column">
	 			<a href="/admin.php/auth/userEdit/?id=<?php echo $user->user_id ?>" class="update">编辑</a>
					</span> &nbsp;  <a href="/admin.php/auth/userDelete/?id=<?php echo $user->user_id ?>" title="删除" class="delete">删除</a>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
</div>
				</td>
		</tr>
	</tbody>
</table>
