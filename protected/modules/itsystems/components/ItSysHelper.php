<?php
 class ItSysHelper{
  public static $email_subject = "IT Systems | {type} | {system} | {status}";
  public static $email_body = "A {type} request for {system} is now at status '{status}'. <a href='{link}'>Click here</a> to view the request details.";

  public static function renderManagementInterface($emp_id){
    Yii::import('itsystems.models.Request');
    Yii::import('itsystems.models.System');
    $data = Request::model()->findAll("employee_id = '$emp_id'");
    include Yii::getPathOfAlias('itsystems.views.request').'/interface.php'; 
  }
  
  public static function isAdmin(){
    return Yii::app()->user->getState('role') == 'ADMIN';
  }
  
  public static function getModuleBaseUrl(){
    return '/itsystems';
  }
  
  public static function queueMail($admins,$model){
    //echo '<pre>'; print_r($users); echo '</pre>'; 
    $subject = str_replace('{type}', $model->type, self::$email_subject); 
    $subject = str_replace('{system}', $model->system->name, $subject);
    $subject = str_replace('{status}', $model->status, $subject);
    $body = str_replace('{type}', $model->type, self::$email_body);
    $body = str_replace('{system}',  $model->system->name, $body);
    $body = str_replace('{status}',  $model->status, $body);
    $body = str_replace('{link}', Yii::app()->createAbsoluteUrl('itsystems/request/view/id/'.$model->id), $body);
    foreach($admins as $admin){
      Helper::queueMail($admin->username,$subject,$body);
    } 
  
  }
 }
?>