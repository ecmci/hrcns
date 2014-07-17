<?php
/**
 *  Cron Job
 *  Sends email alert concerning employees who have reached their 3rd month from date of hire
 */    
class ThirdMonthReviewPoolerCommand extends CConsoleCommand{
  public function run($args){
    self::poolThirdMonthReport();   
  }
  
  public static function poolThirdMonthReport(){
    $error[] = 'ThirdMonthReviewPoolerCommand executing';
    try{
      $hired_three_months_ago = date('Y-m-d',strtotime("- 3 months",time()));
      $error[] = "Attempting to query employees hired last $hired_three_months_ago";
      $data = Yii::app()->db->createCommand()
              ->select("employee.emp_id, concat(employee.last_name,', ',employee.first_name) as name, employment.date_of_hire, employment.facility_id")
              ->from('hr_workflow_change_notice notice') 
              ->join('hr_employee_employment employment','employment.id =  notice.employment_profile_id')
              ->join('hr_employee employee','employee.emp_id = employment.emp_id')
              ->where("notice.notice_type = 'NEW_HIRE'")
              ->andWhere("notice.status = 'APPROVED'")
              ->andWhere("employment.date_of_hire = DATE(NOW()-INTERVAL 3 MONTH)")
              ->queryAll();
      $count = 0;
      if(!empty($data)){
        $count = sizeof($data);
        $error[] = "Found $count employees";
        foreach($data as $d){   
          $error[] = 'Processing '.$d['name'];
          $subject = Yii::app()->name." | 3rd Month Review Alert | ".$d['name'];
          $message = $d['name'].", who was hired last ".$d['date_of_hire'].", marks his/her third month today. Search ".$d['name']."'s profile using the Employee ID: ".$d['emp_id'].".";
          
          //inform only the BOM assigned at employee's facility
          $c = new CDbCriteria;
          $c->select = 't.*, user.username as user_id';
          $c->condition = ("t.facility_handled_ids LIKE '".$d['facility_id']."'");
          $c->addCondition("t.group = 'BOM'");
          $c->join = 'left outer join user on user.idUSER = t.user_id';
          $users = HrUser::model()->findAll($c);
          foreach($users as $user){            
            Helper::queueMail($user->user_id,$subject,$message);
          }  
        }
      }else{
        $error[] = "Found 0 employees";  
      }
      $error[] = 'Execution sucessfull';
    }catch(Exception $ex){
      $error[] = 'Fatal Error! : '.$ex->getMessage();
    }
    echo implode('...',$error)."\n"; 
    Yii::log(implode('...',$error),'error','app');
  }

}
?>