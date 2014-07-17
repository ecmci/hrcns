<?php
defined('YII_DEBUG') or define('YII_DEBUG',true);
 
// including Yii
$yii=dirname(__FILE__).'/y/framework/yii.php';
require_once($yii);
 
// we'll use a separate config file
$config=dirname(__FILE__).'/protected/config/console.php';
 
// creating and running console application
Yii::createConsoleApplication($config)->run();
?>