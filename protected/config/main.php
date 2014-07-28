<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/yii-bootstrap');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'EvaCare',
  'theme'=>'yii-bootstrap',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
    'application.models.hr.*',
    'application.models.req.*',
		'application.components.*',
    'ext.giix-components.*',
	),
  
  'aliases' => array(
    //If you manually installed it
    'xupload' => 'ext.xupload'
  ),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'tar'=>array(
      'defaultController' => 'home',
    ),
    'v2',
		'itsystems'=>array(),
    'license'=>array(),
    'kiosk'=>array(),
    'carboncopy'=>array(),
    'adminoverride'=>array(),
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'sh*t',
      'generatorPaths'=>array(
          'bootstrap.gii',
      ),
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('192.168.1.48','::1'),
		),
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
      'class' => 'WebUser',
      'authTimeout'=>'3600' //logout user after x seconds of inactivity
		),
    'bootstrap'=>array(
        'class'=>'bootstrap.components.Bootstrap',
    ),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			//'showScriptName'=>false,
      'caseSensitive'=>false,
      'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
    */
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=hrcns',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'admin1937',
			'charset' => 'utf8',
      'initSQLs'=>array("set time_zone='-07:00';"),  // set timezone to Los Angeles
      //'enableParamLogging'=>true,
      //'enableProfiling'=>true,
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning, info',
				),
//         array(
// 					'class'=>'CProfileLogRoute',
// 					'report'=>'summary',
// 				),
				// uncomment the following to show log messages on web pages
				
 				array(
 					'class'=>'CWebLogRoute',
 				),
				
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
    'hrEmail'=>'julian.sylve@evacare.com',
    'hrPhone'=>'(310) 889 9929',
		'adminEmail'=>'steven.l@evacare.com',
    'mailerFrom'=>'noreply@evacare.com',
    'adminPhone'=>'(310) 882 5122 ext. 108',
    'dateFormat'=>'F j, Y',
    'uploads_dir'=>'hrcns/uploads',
    'uploads_url'=>'uploads',
	),
);
