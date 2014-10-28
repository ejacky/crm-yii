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
				<th id="is-visible-grid_c0">系统名称</th>
				<th id="is-visible-grid_c1">显示名称</th>
				<th id="is-visible-grid_c1">权限名称</th>
				<th id="is-visible-grid_c1">权限显示名称</th>
				<th id="is-visible-grid_c6" class="button-column" style="width: 100px">操作</th>
			</tr>
		</thead>
		<tbody>
		<?php //$data = empty($_GET['folderid'])? $categorydata : $folder ;?>
		<?php foreach ($roleInfo as $role):?>
			<tr class="odd" class="even">
				<td><?php echo $role->system_name ?></td>
				<td><?php echo $role->display_name ?></td>
				<td><?php echo $role->task_system_name ?></td>
				<td><?php echo $role->task_display_name ?></td>
				<td class="button-column"><span>
	 			<a href="/admin.php/auth/roleEdit/?id=<?php echo $role->id?>" class="update">编辑</a>
					</span> &nbsp;  <a href="javascript:checkAndUrl('/admin.php/auth/roleDelete/?id=<?php echo $role->id?>')" title="删除" class="delete">删除</a>
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