<h1>关于页面</h1>
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