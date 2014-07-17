<?php
 class KioskApp{
  public static $email_subject = "{sys} | {id} | {facility} | {type} | {position} | {status}";
  public static $email_body = "A {type} notice has been recently submitted and is now at status {status}. <a href='{link}'>Click here</a> to view the request details.";

  
  public static function getFacilityList(){
    return CHtml::listData(Facility::model()->findAll(),'idFACILITY','title');
  }
  
  public static function queueMail($users,$model){
    $employmentProfile = EmployeeEmployment::model()->find("id = '".$model->employment_profile_id."'");
    $facility = Facility::model()->find("idFACILITY = '".$employmentProfile->facility_id."'")->acronym;
    $position = Position::model()->find("code = '".$employmentProfile->position_code."'")->name;
    $subject = str_replace('{type}', $model->notice_type, self::$email_subject); 
    $subject = str_replace('{status}', $model->status, $subject);
    $subject = str_replace('{sys}', Yii::app()->name, $subject);
    $subject = str_replace('{id}', $model->id, $subject);
    $subject = str_replace('{facility}', $facility, $subject);
    $subject = str_replace('{position}', $position, $subject);
    $body = str_replace('{type}', $model->notice_type, self::$email_body);
    $body = str_replace('{status}',  $model->status, $body);
    $body = str_replace('{link}', Yii::app()->createAbsoluteUrl('/hr/workflowchangenotice/view/id/'.$model->id), $body);
    foreach($users as $user){
      Helper::queueMail($user->username,$subject,$body);
    }
  }
 }
?>