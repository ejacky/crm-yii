<?php if (Yii::app()->user->hasFlash('pageInfo')) : ?>
<?php $this->renderPartial('application.views.page.infoSummary', array('pageInfo'=>Yii::app()->user->getFlash('pageInfo'))); ?>
<?php endif; ?>

<div class="form_title">
<h3>属性设置</h3>
<h4>可以在这里设置模块用到的属性</h4>
</div>

<?php if (isset($formErrors)) : ?>
<?php $this->renderPartial('application.views.form.errorSummary', array('formErrors'=>$formErrors)); ?>
<?php endif; ?>

<form action="/admin.php/auth/property/" class="form" method="post">
<table>
<tr>
    <th>职位类型：</th>
    <td style="width:400px;">
		<textarea name="title" style="width:400px;height:300px"><?php echo $title ?></textarea>
		<p>在这里输入所有可供选择的职位，使用“,”分隔</p>
	</td>
	<td></td>
</tr>
<tr>
   	<th></th>
   	<td><input type="submit" value="保存" /></td>
</tr>

</table>
</form>
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