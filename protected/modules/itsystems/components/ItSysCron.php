<?php
 class ItSysCron{
    public static function noticeRequestPoolerCron(){
      $error= array();
      $error[] = 'ItSysCronJob: noticeRequestPoolerCron executing';
      try{
        $c = new CDbCriteria;
        $c->compare('status','APPROVED');
        $c->addCondition('DATE(`timestamp_corp_signed`) = '.new CDbExpression('CURDATE()'));
        $notices = WorkflowChangeNotice::model()->findAll($c);
        $error[] = 'Processing '.sizeof($notices).' records...';   
        if(!empty($notices)){
          $count_success= 0;
          foreach ($notices as $key=>$value) {
            $request = new Request('create');
            switch($value->notice_type){
              case 'NEW_HIRE' :
              case 'RE_HIRE' : 
                $request->type = 'NEW';
              break;
              case 'TERMINATED' : 
                $request->type = 'DEACTIVATE';
              break;
            }
            $request->employee_id = $value->employmentProfile->emp_id;
            $request->system_id = SystemPosition::getSystemsForPosition($value->employmentProfile->position_code);
            $request->note = 'Initiated By CRON Job.';
            $request->hr_workflow_notice_id = $value->id;
            if($request->submitRequest())
              $count_success++;        
          }
          $error[] = "Submitted: $count_success";    
        }
      }catch(Expcetion $ex){
        $error[] = $ex->getMessage();  
      }
      $error[] = 'Execution Done.';
      Yii::log(implode('... ',$error),'info','app');
    }
 }
?>