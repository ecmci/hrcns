<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Eva Care eWorkflow',

	// preloading 'log' component
	'preload'=>array('log'),
  
  // preload components
  'import'=>array(
        'application.components.*',
        'application.models.*',
        'application.models.hr.*',
        'ext.giix-components.*', // giix components
        'ext.phpmailer.*',
    ),

	// application components
	'components'=>array(
//     'db'=>array(
// 			'connectionString' => 'mysql:host=localhost;dbname=hrcns',
// 			'emulatePrepare' => true,
// 			'username' => 'root',
// 			'password' => 'admin1937',
// 			'charset' => 'utf8',
// 		),

    'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=ecmcicom_evahrnotice',
			'emulatePrepare' => true,
			'username' => 'ecmcicom_evahr',
			'password' => 'evahr1937',
			'charset' => 'utf8',
      'initSQLs'=>array("set time_zone='-07:00';"),  // set timezone to Los Angeles
      //'enableParamLogging'=>true,
      //'enableProfiling'=>true,
		),
    
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning, info',
          'logFile'=>'cron.log',
				),
			),
		),
	),
  
  //params
  'params'=>array(
		// this is used in contact page
		'adminEmail'=>'steven.l@evacare.com',
    'mailerFrom'=>'noreply@evacare.com',
    'adminPhone'=>'(310) 882 5122 ext. 108',
    'dateFormat'=>'F j, Y',
	),
);