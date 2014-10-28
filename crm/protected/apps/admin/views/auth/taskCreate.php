<?php if (Yii::app()->user->hasFlash('pageInfo')) : ?>
<?php $this->renderPartial('application.views.page.infoSummary', array('pageInfo'=>Yii::app()->user->getFlash('pageInfo'))); ?>
<?php endif; ?>
<?php if (Yii::app()->user->hasFlash('errorInfo')) : ?>
<?php $this->renderPartial('application.views.page.errorSummary', array('errorInfo'=>Yii::app()->user->getFlash('errorInfo'))); ?>
<?php endif; ?>

<div class="form_title">
	<h3>权限设置</h3>
<h4>通过这里可以创建一个系统使用的权限</h4>
</div>

<div class="form">
<form action="/admin.php/auth/<?php echo $type == 'edit' ? 'taskEdit' : 'taskCreate' ?>" method="post">
	<?php if ($type == 'edit') : ?>
	<input type="hidden" name="id" value="<?php echo $model->id ?>" />
	<?php endif; ?>
	<input type="hidden" id="departmentId" name="departmentId" value="" />
	<table>
	<tr>
	    <th><em>*</em>权限系统名称：</th>
	    <td style="width:200px;">
			<input type="text" name="systemName" value="<?php echo $type == 'edit' ? $model->system_name : '' ?>" rule="notEmpty" />
			<p>这里设置的名称，为程序系统中使用的名称，格式必须为英文</p>
		</td>
	    <td><span>请输入分类名称</span></td>
	</tr>
	<tr>
	    <th><em>*</em>权限名称：</th>
	    <td style="width:200px;">
			<input type="text" name="displayName" value="<?php echo $type == 'edit' ? $model->display_name : '' ?>" rule="notEmpty" />
		</td>
	    <td><span>请输入分类名称</span></td>
	</tr>
	<tr>
	    <th>权限说明：</th>
	    <td style="width:200px;"><textarea name="description"><?php echo $type == 'edit' ? $model->description : '' ?></textarea></td>
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
<?php 
$this->menu = array(
                array('name' => '部门和职位', 'subitem' => array(
                        array('name' => '部门和职位展示', 'href' => Yii::app()->getController()->createUrl('index'), 'flag' => 'index'),
                        array('name' => '部门和职位列表', 'href' => Yii::app()->getController()->createUrl('departmentList'), 'flag' => 'departmentList'),
                        array('name' => '部门和职位创建', 'href' => Yii::app()->getController()->createUrl('departmentCreate'), 'flag' => 'departmentCreate'),
                    )
                ),
                array('name' => '权限', 'subitem' => array(
                        array('name' => '权限列表', 'href' => Yii::app()->getController()->createUrl('taskList'), 'flag' => 'taskList'),
                        array('name' => '权限创建', 'href' => Yii::app()->getController()->createUrl('taskCreate'), 'flag' => 'taskCreate'),
                        array('name' => '角色（权限组）列表', 'href' => Yii::app()->getController()->createUrl('roleList'), 'flag' => 'roleList'),
                        array('name' => '角色（权限组）创建', 'href' => Yii::app()->getController()->createUrl('roleCreate'), 'flag' => 'roleCreate'),
                    )
                ),
                array('name' => '属性设置', 'subitem' => array(
                        array('name' => '职位信息设置', 'href' => Yii::app()->getController()->createUrl('property'), 'flag' => 'property'),
                    )
                ),

            );
?>