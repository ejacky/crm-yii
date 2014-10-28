<?php

class SideMenuAdmin {

	static $staff = array(
		array('name' => '功能菜单', 'subitem' => array(
				array('name' => '员工列表', 'href' => 'index', 'flag' => 'index'),
				array('name' => '增加员工', 'href' => 'addStaff', 'flag' => 'addStaff'),
			)
		),
	);
	static $assist = array(
		array('name' => '数据管理', 'subitem' => array(
				array('name' => '数据清空', 'href' => 'index', 'flag' => 'index'),
				array('name' => '数据保存', 'href' => 'dataBak', 'flag' => 'databak'),
                                array('name' => '数据转存', 'href' => 'migration', 'flag' => 'migration'),
			)
		),
		array('name' => '系统管理', 'subitem' => array(
				array('name' => '系统升级', 'href' => 'systemUpdate', 'flag' => 'systemUpdate'),
			)
		),
	);
	static $customForm = array(
		array('name' => '功能菜单', 'subitem' => array(
				array('name' => '表单列表', 'href' => 'paFormList', 'flag' => 'paFormList'),
				array('name' => '新建表单', 'href' => 'paFormCreate', 'flag' => 'paFormCreate'),
				array('name' => '新建字段', 'href' => 'paFieldCreate', 'flag' => 'paFieldCreate'),
			),),
	);
	
	static $tableSet = array(
			array('name' => '功能菜单', 'subitem' => array(
				array('name' => '新建表格', 'href' => 'tableIndex', 'flag' => 'tableIndex'),
				array('name' => '表格列表', 'href' => 'index', 'flag' => 'index'),
			),),
	);
	
	static $auth = array(
		array('name' => '部门和职位', 'subitem' => array(
				array('name' => '部门和职位列表', 'href' => 'departmentList', 'flag' => 'departmentList'),
				array('name' => '部门和职位创建', 'href' => 'departmentCreate', 'flag' => 'departmentCreate'),
			)
		),
		array('name' => '权限', 'subitem' => array(
				array('name' => '权限列表', 'href' => 'taskList', 'flag' => 'taskList'),
				array('name' => '权限创建', 'href' => 'taskCreate', 'flag' => 'taskCreate'),
				array('name' => '角色（权限组）列表', 'href' => 'roleList', 'flag' => 'roleList'),
				array('name' => '角色（权限组）创建', 'href' => 'roleCreate', 'flag' => 'roleCreate'),
			)
		),
		array('name' => '属性设置', 'subitem' => array(
				array('name' => '职位信息设置', 'href' => 'property', 'flag' => 'property'),
			)
		),
	);
	
	static $organization = array(
		array('name' => '部门和职位', 'subitem' => array(
				array('name' => '部门列表', 'href' => 'departmentList', 'flag' => 'departmentList'),
				array('name' => '部门创建', 'href' => 'departmentMaker', 'flag' => 'departmentMaker'),
				array('name' => '职位列表', 'href' => 'positionList', 'flag' => 'positionList'),
				array('name' => '职位创建', 'href' => 'positionMaker', 'flag' => 'positionMaker'),
			)
		),
	);
	
	static $authority = array(
		array('name' => '权限管理', 'subitem' => array(
				array('name' => '角色列表', 'href' => 'roleList', 'flag' => 'roleList'),
				array('name' => '角色创建', 'href' => 'roleMaker', 'flag' => 'roleMaker'),
				array('name' => '权限列表', 'href' => 'taskList', 'flag' => 'taskList'),
				array('name' => '权限创建', 'href' => 'taskMaker', 'flag' => 'taskMaker'),
			)
		),
	);

	static public function getSideMenu()
	{
		 $con = Yii::app()->controller->id;
		 return self::$$con;
	}
}

