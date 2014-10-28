<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'task-grid',
	'dataProvider'=>$model,
    'template'=>'<div align=center>权限列表</div>{items}{summary}{pager}',
	'columns'=>$columns,
)); ?>