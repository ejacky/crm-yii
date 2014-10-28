<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

$backend = dirname(dirname(__FILE__));
$fontend = dirname(dirname($backend));
Yii::setPathOfAlias('backend',$backend);
if (strpos($_SERVER['REQUEST_URI'], 'customForm'))
{
        $backend = dirname($backend) . '/core/form';
}
if ((strpos($_SERVER['REQUEST_URI'], 'tableSet')))
{
        $backend = dirname($backend) . '/core/table';
}

return array(
		'basePath'=>$fontend,
		'controllerPath'=>$backend.'/controllers',
		'viewPath'=>$backend.'/views',
		'runtimePath'=>$backend.'/runtime',
		'name'=>'CRM管理系统',
		'defaultController'=>'login',
		'language' => 'zh_cn',

	// preloading 'log' component
	// 'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.components.db_config.php',
		'application.components.cms.*',
		'application.components.co.*',
		'application.components.pa.*',
		'application.components.table.*',
		'application.components.form.*',
                'application.apps.admin.components.*',
                'application.apps.admin.model.*',
                'application.modules.core.form.components.*',
                'application.apps.core.form.components.*',
                'application.apps.core.form.models.*',
                'application.apps.core.table.components.*', 
		'application.admin.config.SideMenu',
		'application.views.form.formTemplate',
		'system.web.helpers.*'
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123456',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			//'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'class'=>'CoWebUser',
		),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
//				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
//				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
//				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                            
 //     'gii/<controller:[\w\-]+>'=>'gii/<controller>',
  //    'gii/<controller:[\w\-]+>/<action:\w+>'=>'gii/<controller>/<action>',
                                                        
  //    '<controller:[\w\-]+>/<action:\w+>'=>'form/<controller:[\w\-]+>/<action:\w+>',
  //    'form/<controller:[\w\-]+>/<action:\w+>'=>'form/<controller>/<action>',

                          
			),
		),
		
		   'db'=>require(dirname(__FILE__).DIRECTORY_SEPARATOR.'db_config.php'),
	
		'errorHandler'=>array(
			// use 'site/error' action to display errors
				'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				///*
				array(
					'class' => 'CWebLogRoute',
					'levels' => 'profile,trace',
				),
				array(
					'class' => 'CProfileLogRoute',
					'levels' => 'profile',
				),
				//*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);

require_once 'db_config.php';
