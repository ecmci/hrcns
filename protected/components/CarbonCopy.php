<?php
/*   Cron
*    Pools every 15 minutes those recipients that need to be notified when a notice is at a certain status 15 minutes ago
*/
class CarbonCopy{
  private $error;
  public static $POLL_INTERVAL_MINS = '15';
  public function run($args){
    $this->error[] = 'CarbonCopyPoolerCommand executing';
    try{
      $statuses = Yii::app()->db->createCommand()
                  ->select("distinct(workflow_notice_status) as status")
                  ->from("hr_workflow_change_carbon_copy_recipient")
                  ->queryAll();                   
      //print_r($statuses); 
      foreach($statuses as $key=>$value){
        $notices = $this->findNotices($value['status']);
        if(!empty($notices)) $this->mailNotices($notices,$value['status']);
      }  
    }catch(Exception $ex){
      $this->error[] = 'Fatal Error! : '.$ex->getMessage();
    }
    Yii::log(implode("\n",$this->error),'error','app');  
  }
  
  private function mailNotices($notices,$status){
    $r=array();
    $users = Yii::app()->db->createCommand()
            ->select('recipient_email')
            ->from('hr_workflow_change_carbon_copy_recipient')
            ->where("workflow_notice_status = '$status'")
            ->queryAll();
    if (empty($users)) return;
    $data = '<table border="1" style="border-collapse:collapse;">';
    $data .= '<tr><th>ID</th><th>Type</th><th>Status</th><th>Employee</th><th>Facility</th><th></th></tr>'; 
    foreach($notices as $n){
      $data .= '<tr><td>'.$n['id'].'</td><td>'.$n['notice_type'].'</td><td>'.$n['status'].'</td><td>'.$n['employee'].'</td><td>'.$n['facility'].'</td><td></td></tr>';
    }
    $data .= '</table>';
    $subject = Yii::app()->name." | $status Notices | Update Alert";
    $message = 'The following notices have been recently update: <br/><br/>'.$data.'';
    foreach($users as $u){
      Helper::queueMail($u['recipient_email'],$subject,$message);
      $r[] = $u['recipient_email'];
    }
    $this->error[] = 'Carbon copied '.implode(', ',$r);
  }
  
  
  private function findNotices($status){
    $f = 'Y-m-d H:i';
    $now = time();
    $mins_now = date($f,$now);
    $mins_ago = date($f,strtotime("-".self::$POLL_INTERVAL_MINS." minutes",$now));
    $this->error[] = "Querying $status notices updated between $mins_ago and $mins_now";
    $data = Yii::app()->db->createCommand()
          ->select('a.id, a.notice_type, a.processing_group, a.status, f.title as facility, concat(e1.last_name, ", ",e1.first_name) as employee')
          ->from('hr_workflow_change_notice a')
          ->join('hr_employee_employment e','e.id =  a.employment_profile_id')
          ->join('hr_employee e1','e1.emp_id = e.emp_id')
          ->join('facility f','f.idFACILITY = e.facility_id')
          ->orWhere("a.timestamp_bom_signed between '$mins_ago' and '$mins_now'")
          ->orWhere("a.timestamp_fac_adm_signed between '$mins_ago' and '$mins_now'")
          ->orWhere("a.timestamp_mnl_signed between '$mins_ago' and '$mins_now'")
          ->orWhere("a.timestamp_corp_signed between '$mins_ago' and '$mins_now'")
          ->andWhere("a.status = '$status'")
          ->queryAll();
     $this->error[] = 'Found '.(!empty($data) ? sizeof($data) : 0).' notices';
     return $data;
  }
} 
?>