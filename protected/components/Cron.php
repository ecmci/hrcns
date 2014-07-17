<?php

class Cron{

  public static function test(){
    try{
      $objEmail = self::getEmailerObject();
      
      //echo '<pre>';   print_r($objEmail);     echo '</pre>';  exit();
      
      if(empty($objEmail)) throw new Exception('Emailer object null!');
      
      $objEmail->SetFrom('steven@evacare.net', Yii::app()->name);

      $objEmail->AddAddress('steven.l@evacare.com');

      $objEmail->Subject = 'test';

      //$mailer->Body = $mail->message;

      $objEmail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

      $objEmail->MsgHTML('test');

      $objEmail->Priority = '1';

      if($objEmail->Send()){





      }else{
        throw new Exception('Sending failed!');


      }
    }catch(Exception $ex){
      echo $ex->getMessage();
    }
    
  }
  
  public static function poolWeeklyReportForChangeNotice(){

    Yii::log('poolWeeklyReportForChangeNotice executing...','info','app');

    $message = "";

    try{

      // get the pending requests

      

      // for each facility, send a summary report only for those with pending notices

      $facilities = Facility::model()->findAll(array(

        'select'=>'idFACILITY, acronym'

      ));      

      foreach($facilities as $facility){

        $notices = self::getActiveChangeNoticeRequests($facility->idFACILITY);

        if(!empty($notices)){

          $headings = array('ID','Type','Status','Processing Group','Date Requested','Employee','Position','Facility');

          $rows = array(); //2D

          foreach($notices as $i=>$notice){

            $rows[$i][0] = $notice->id;

            $rows[$i][1] = $notice->notice_type;

            $rows[$i][2] = $notice->status;

            $rows[$i][3] = $notice->processing_group;

            $rows[$i][4] = $notice->timestamp;

            $rows[$i][5] = ($notice->employmentProfile) ? $notice->employmentProfile->emp->getFullName() : 'pending...';

            $rows[$i][6] = ($notice->employmentProfile) ? $notice->employmentProfile->positionCode->name : 'pending...';

            $rows[$i][7] = $notice->facility;               

          }

          $table = self::renderSummaryTable($headings,$rows);

          $users = self::getUsersPerFacility($facility->idFACILITY);

          $subject = Yii::app()->name.' | Weekly Report | Active Change Notice Requests | '.$facility->acronym;

          foreach($users as $user){

            Helper::queueMail($user->user_id,$subject,$table);  

          }

        }

      }     

    }catch(Exception $ex){

      $message = $ex->getMessage();

      Yii::log('poolWeeklyReport: Fatal Error! '.$ex->getMessage(),'error','app');  

    }

    Yii::log('poolWeeklyReportForChangeNotice execution done.','info','app');

  }

  

  public static function getUsersPerFacility($facility_id){

    $c = new CDbCriteria;

    $c->select = 't.*, user.username as user_id';

    $c->condition = ("t.facility_handled_ids LIKE '%,$facility_id,%'");

    $c->join = 'left outer join user on user.idUSER = t.user_id';

    return HrUser::model()->findAll($c);   

  }

  

  

  public static function renderSummaryTable($headings=array(),$rows=array()){

      $table = "<style>table{border-collapse:collapse;}table, td, th{border:1px solid black;}</style>";

      $table .= '<table>';

      $table .= '<thead>';

        $table .= '<tr>';

        foreach($headings as $heading) $table .= "<th>$heading</th>"; 

        $table .= '<thead>';

        $table .= '</tr>';

      $table .= '<tbody>';

        foreach($rows as $row){

          $table .= '<tr>';

          foreach($row as $data){

            $table .= "<td>$data</td>";  

          }

          $table .= '</tr>';  

        }   

      $table .= '</tbody>';

    $table .= '</table>';

    return $table;

  }

  

  public static function getActiveChangeNoticeRequests($facility_id){

    $c = new CDbCriteria;

    $c->select = 't.*';

    $c->join = "left outer join hr_employee_employment employment on employment.id = t.employment_profile_id";

    $c->addInCondition('t.status',array(WorkflowChangeNotice::$WAITING, WorkflowChangeNotice::$NEW));

    $c->compare('employment.facility_id',$facility_id);

    return WorkflowChangeNotice::model()->findAll($c);

  }                             

  

  public static function poolEmails(){

    Yii::log('poolEmails executing...','info','app');

    $message = "";

    try{

      $mails = self::getEmailQueue();

      foreach($mails as $mail){

        $mailer = self::getEmailerObject();

        $mailer->SetFrom($mail->from, Yii::app()->name);

        $mailer->AddAddress($mail->to);

        $mailer->Subject = $mail->subject;

        //$mailer->Body = $mail->message;

        $mailer->AltBody = 'To view the message, please use an HTML compatible email viewer!';

        $mailer->MsgHTML($mail->message);

        $mailer->Priority = '1';

        if($mailer->Send()){

          EmailQueue::model()->updateByPk($mail->id,array('sent'=>'1','sent_timestamp'=>new CDbExpression('NOW()')));

          $message = "poolEmails: Successfully sent notification with subject '$mail->subject' to $mail->to";

        }else{

          $message = "poolEmails: Failed to send notification with subject '$mail->subject' to $mail->to";

        }

        echo $message."\n";

        Yii::log($message,'info','app');  

      } 

    }catch(Exception $ex){

      Yii::log('poolEmails: Fatal Error! '.$ex->getMessage(),'error','app'); 

    }

    Yii::log('poolEmails execution done.','info','app');

  }

  



  public static function getEmailQueue(){

    return EmailQueue::model()->findAll("sent = '0'");    

  } 

  

  public static function getEmailerObject0(){

    Yii::import('ext.phpmailer.JPhpMailer');

    $emailerObj = new JPhpMailer;

    $emailerObj->IsSMTP(true);

    $emailerObj->IsHTML(true);

    $emailerObj->Mailer = "smtp";

    $emailerObj->Host = 'smtpdsl4.pldtdsl.net';

    $emailerObj->Port = '587';    

    return $emailerObj;

  }
  
  public static function getEmailerObject(){

    Yii::import('ext.phpmailer.JPhpMailer');

    $emailerObj = new JPhpMailer;

    //$emailerObj->IsSMTP(true);

    //$emailerObj->IsHTML(true);

    //$emailerObj->Mailer = "smtp";

    //$emailerObj->Host = 'smtpdsl4.pldtdsl.net';

    //$emailerObj->Port = '587';    

    return $emailerObj;

  }

   

}

?>