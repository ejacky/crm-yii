<?php

class SideMenu {

	static $file = array(
		array('name' => '功能菜单', 'subitem' => array(
				array('name' => '文件列表', 'href' => '/index.php/file/index', 'flag' => 'index'),
				array('name' => '文件上传', 'href' => '/index.php/file/upload', 'flag' => 'upload'),
				array('name' => '上传设置', 'href' => '/index.php/file/setting', 'flag' => 'setting')
			),
		),
	);
	static $account = array(
		array('name' => '任务信息', 'subitem' => array(
				array('name' => '查看客户', 'href' => 'clientBrowse', 'flag' => 'clientBrowse'),
				array('name' => '查看联系人', 'href' => 'contactBrowse', 'flag' => 'contactBrowse'),
			),
		),
		array('name' => '课程管理', 'subitem' => array(
				array('name' => '添加学员', 'href' => '/index.php/course/addTrainee', 'flag' => 'addTrainee'),
				array('name' => '问卷管理', 'href' => '/index.php/course/questionnaireIndex', 'flag' => 'questionnaireIndex'),
			),
		),
	);
	//后台controller
	static $assist = array(
		array('name' => '功能菜单', 'subitem' => array(
				array('name' => '数据清空', 'href' => 'index', 'flag' => 'index'),
				array('name' => '数据保存', 'href' => 'dataBak', 'flag' => 'databak'),
                    		array('name' => '数据转存', 'href' => 'migration', 'flag' => 'migration'),
			)
		),
		array('name' => '功能菜单', 'subitem' => array(
				array('name' => '系统升级', 'href' => 'systemUpdate', 'flag' => 'systemUpdate'),
			)
		),
	);
	static $client = array(
		array('name' => '功能菜单', 'subitem' => array(
				array('name' => '客户列表', 'href' => 'index', 'flag' => 'index'),
				array('name' => '新建客户', 'href' => 'addClient', 'flag' => 'addClient'),
//                                array('name' => '联系记录', 'href' => 'clientBrowse', 'flag' => 'clientBrowse'),
			),
		),
	);
	static $contact = array(
		array('name' => '功能菜单', 'subitem' => array(
				array('name' => '联系人展示', 'href' => 'index', 'flag' => 'index'),
				array('name' => '增加联系人', 'href' => 'addContact', 'flag' => 'addContact'),
//                               array('name' => '联系记录', 'href' => 'contactBrowse', 'flag' => 'contactBrowse'),
			),
		),
	);
	static $course = array(
		array('name' => '功能菜单', 'subitem' => array(
				array('name' => '课程显示', 'href' => 'index', 'flag' => 'index'),
				array('name' => '添加课程', 'href' => 'addCourse', 'flag' => 'addCourse'),
				array('name' => '讲师管理', 'href' => 'lecturerIndex', 'flag' => 'lecturerIndex'),
				array('name' => '添加讲师', 'href' => 'addLecturer', 'flag' => 'addLecturer'),
				array('name' => '添加问卷', 'href' => 'addQuestionnaire', 'flag' => 'addQuestionnaire'),
			),
		),
	);
	static $staff = array(
	);
	static $calendar = array(
	);
        
        //for module
	static $customForm = array(
		array('name' => '功能菜单', 'subitem' => array(
				array('name' => '表单列表', 'href' => 'index', 'flag' => 'index'),
				array('name' => '新建表单', 'href' => 'NewForm', 'flag' => 'NewFormff'),
				array('name' => '新建字段', 'href' => 'NewField', 'flag' => 'NewField'),
			),),
	);
        
	static $tableSet = array(
			array('name' => '功能菜单', 'subitem' => array(
				array('name' => '新建表格', 'href' => 'tableIndex', 'flag' => 'tableIndex'),
				array('name' => '表格列表', 'href' => 'index', 'flag' => 'index'),
			),),
	);        

	static public function getSideMenu() {
		$con = Yii::app()->controller->id;
                
		return self::$$con;
	}

}

