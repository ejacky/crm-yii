<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'auth-grid',
	'dataProvider'=>$model,
    'template'=>'<div align=center>部门列表</div>{items}{summary}{pager}',
	'columns'=>$columns,
)); ?>