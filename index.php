<?php

/*
  FORCE HTTPS

//echo '<pre>';  print_r($_SERVER);   echo '</pre>';  exit();
if(!isset($_SERVER['HTTPS'])){
  header('Location: https://' . $_SERVER['SERVER_NAME']. '/hrcns');
  exit();
}
*/

// set timezone to Los Angeles
date_default_timezone_set('America/Los_Angeles');
// change the following paths if necessary
$yii=dirname(__FILE__).'/y/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
//defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',1);

require_once($yii);
Yii::createWebApplication($config)->run();
