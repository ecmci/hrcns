<?php
 class LicenseApp extends Helper{
  public static $email_subject = "{system} | License Expired | {name} of {employee}";
  public static $email_body = "{name} license of {employee} has been expired as of {date}. To view the details, login to {system}, go to the license management module and search for ID '{id}'. To stop this alert, either update the expiration date or delete the license.";

  public static function renderManagementInterface($emp_id){
    Yii::import('license.models.License');
    $data = License::model()->findAll("emp_id = '$emp_id'");
    include Yii::getPathOfAlias('license.views.license').'/interface.php'; 
  } 
 
  public static function truncate($text){
    return  substr($text,0,20).'...';  
  }
  
  public static function isOwner($id){
    if(Yii::app()->user->getState('role') == 'ADMIN') 
      return true;   // super users ok
    
    $current_user = Yii::app()->user->getState('id');
    $license = License::model()->findByPk($id);
    if($license->submitted_by == $current_user)
      return true;  
    return $license->emp_id ==  $current_user;
  }
  
  public static function dailyReportPooler(){
    try{
      $error[] = 'License::dailyReportPooler executing';
      $now = date('Y-m-d',time());
      $subject = str_replace('{system}', Yii::app()->name, self::$email_subject);

      $data = Yii::app()->db->createCommand()
              ->select('hr_employee_license.id, hr_employee_license.name,hr_employee_license.date_of_expiration, concat(hr_employee.last_name,", ",hr_employee.first_name) as employee, hr_employee_employment.facility_id')
              ->from('hr_employee_license')
              ->join('hr_employee','hr_employee.emp_id = hr_employee_license.emp_id')
              ->join('hr_employee_employment','hr_employee_employment.id = hr_employee.active_employment_id')
              ->where('hr_employee_license.date_of_expiration <= CURDATE()')
              ->queryAll();

      $error[] = "Found ".sizeof($data)." expired licenses";
      echo '<pre>';
      $processed=0;
      foreach ($data as $value) {
        //compose the email
        $subject = str_replace('{name}', $value['name'], self::$email_subject);
        $subject = str_replace('{system}', Yii::app()->name, $subject);
        $subject = str_replace('{employee}', $value['employee'], $subject);  
        $body = str_replace('{name}', $value['name'], self::$email_body); 
        $body = str_replace('{employee}', $value['employee'], $body);
        $body = str_replace('{date}', $value['date_of_expiration'], $body);	
        $body = str_replace('{id}', $value['id'], $body);	
        $body = str_replace('{system}', Yii::app()->name, $body);
        
        //inform the BOM concerned
        $boms = Yii::app()->db->createCommand()
                ->select('user.username')
                ->from('hr_user')
                ->join('user','user.idUSER = hr_user.user_id')
                ->andWhere("hr_user.group = 'BOM'")
                ->andWhere("hr_user.facility_handled_ids like '".$value['facility_id']."'")
                ->queryAll();
        foreach ($boms as $bom) {
          Helper::queueMail($bom['username'],$subject,$body);	
        }
        $processed++;
      }
      $error[] = "Processed $processed licenses";
      echo '</pre>'; 
    }catch(Exception $ex){
      $error[] = $ex->getMessage();
    }
    $error[] = 'Done.';
    $message = implode('... ',$error); 
    echo $message; 
    Yii::log($message,'info','app');         
  }
  

 }
?>