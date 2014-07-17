<?php
/*
 * CRON for pooling NEW_HIRE or TERMINATED type notices requests and alerting IT of such
 */
class ItSysNoticePoolerCommand extends CConsoleCommand{
  private $error;
  public function run($args){
    Yii::import('application.modules.itsystems.models.*');
    Yii::import('application.modules.itsystems.components.ItSysHelper');
    $this->error[] = 'ItSysNoticePoolerCommand executing';
    try{
        $c = new CDbCriteria;
        $c->compare('status','APPROVED');
        $c->addCondition('DATE(`timestamp_corp_signed`) = '.new CDbExpression('CURDATE()'));
        $notices = WorkflowChangeNotice::model()->findAll($c);
        $this->error[] = 'Found '.sizeof($notices).' records';   
        foreach($notices as $n){
          $type = '';
          $systems = array();
          $this->error[] = 'Processing Notice '.$n->id;
          switch($n->notice_type){
            case 'NEW_HIRE':  case 'RE_HIRE':
              $type = 'NEW';
              $systems = SystemPosition::getSystemsForPosition($n->employmentProfile->position_code);
              foreach($systems as $s){
                $r = new Request('create');
                $r->employee_id = $n->employmentProfile->emp_id;
                $r->system_id = $s;
                $r->note = 'Initiated By CRON Job';
                $r->cronJob = true;
                $r->save(false);
              }
            break;
            case 'TERMINATED':
              $type = 'DEACTIVATE';
              Request::model()->updateAll(
                array('type' => $type,'active'=>'1','status'=>'PENDING'),
                "employee_id = '".$n->employmentProfile->emp_id."'"
              );
            break;
          }
          $this->error[] = 'Ok';
        }
        $this->error[] = "Done\n";
    }catch(Exception $ex){
      $this->error[] = 'Fatal Error! : '.$ex->getMessage();  
    }
    Yii::log(implode("\n",$this->error),'info','app');  
  }
  
  private function getActiveSystems($emp_id){
    $rq = Request::model()->findAll(array(
      'select'=>'system_id',
      'condition'=>"(employee_id = '$emp_id') and (deactivated_timestamp IS NULL)",
    )); 
    $data = array();
    foreach($rq as $r){
      $data[] = $r->system_id;  
    }
    return $data;
  }
}
?>