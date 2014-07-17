<?php

/**
 * This is the model class for table "hr_workflow_change_notice".
 *
 * The followings are the available columns in table 'hr_workflow_change_notice':
 * @property integer $id
 * @property integer $initiated_by
 * @property string $notice_type
 * @property string $status
 * @property string $processing_group
 * @property integer $processing_user
 * @property integer $profile_id
 * @property integer $personal_profile_id
 * @property integer $employment_profile_id
 * @property integer $payroll_profile_id
 * @property integer $bom_id
 * @property integer $fac_adm_id
 * @property integer $mnl_id
 * @property integer $corp_id
 * @property string $timestamp_bom_signed
 * @property string $timestamp_fac_adm_signed
 * @property string $timestamp_mnl_signed
 * @property string $timestamp_corp_signed
 * @property integer $decision_bom
 * @property integer $decision_fac_adm
 * @property integer $decision_mnl
 * @property integer $decision_corp
 * @property string $comment_bom
 * @property string $comment_fac_adm
 * @property string $comment_mnl
 * @property string $comment_corp
 * @property string $attachment_bom
 * @property string $attachment_fac_adm
 * @property string $attachment_mnl
 * @property string $attachment_corp
 * @property string $timestamp
 */
abstract class WorkflowChangeNotice0 extends CActiveRecord
{  
  
  // db enum values for status
  public static $NEW = 'NEW';
  public static $WAITING = 'WAITING';
  public static $PROCESSING = 'PROCESSING';
  public static $APPROVED = 'APPROVED';
  public static $DECLINED = 'DECLINED';
  public static $CANCELLED = 'CANCELLED';
  public static $FLAG_DAYS = 2;
  public static $FLAG_MONTHS = 1;
  public static $FLAG_YEARS = 1;
  
  
  // foreigners
  public $facility, $employee, $position, $comments, $decision, $effective_from, $effective_to; 
  
  // residents
  public $is_approved='0';
  public $comment;
  public $reason;
  public $reason_other;
  public $attachment = '';
  public $created_days_ago;
  public $summary_of_changes;
  
  //attachments
  public $docs, $file; 
 
 
  public function saveAttachments(){
    if(empty($this->docs)) return true;
    $documents = array();
    foreach($this->docs as $key=>$doc){      
      $filename = Helper::generateFilename($this->profile_id, $key.'-'.$doc);
      $documents[] = $filename;
      $filename = Helper::getUploadsDir().DIRECTORY_SEPARATOR.$filename;
      if($doc->saveAs($filename)){
        Yii::log($doc.' saved.','info','app');  
      }else{
        Yii::log($doc.' not saved!','info','app');
      }      
      
    }
    $this->attachments = implode(',',$documents); 
  }
  
  public function setAttachments(){
    if(empty($this->docs)) return true;
    foreach($this->docs as $key=>$docname){
      $this->docs[$key] = CUploadedFile::getInstance($this,"docs[$key]");      
    }
  }
  

  
  public function getAttachments(){
    $files = explode(',',$this->attachments);
    return $files[2].$files[3];
  }  
 
  public static function getDocsToAttach($type='NEW_HIRE',$sub_type=''){
    $c = new CDbCriteria;
    $c->compare('notice_type',$type);
    $c->compare('notice_sub_type',$sub_type);
    return HrDocuments::model()->findAll($c);  
  }
  
    public function summarizeChanges($current_model, $last_model){
      $cAttributes = $current_model->attributes;
      $lAttributes = $last_model->attributes;
      while($current_value = current($cAttributes)){
        $idx = key($cAttributes);
        if($current_value != $lAttributes[$idx])
          $this->summary_of_changes[] = $idx.'|'.$lAttributes[$idx].'|'.$current_value;
        next($cAttributes);
      }  
    }
    
    public function getAllComments(){
      $comments = '';
      $comments .= (!empty($this->comment_bom)) ? '<strong>BOM</strong>: "'.$this->comment_bom.'"<br />' : '';
      $comments .= (!empty($this->comment_fac_adm)) ? '<strong>FAC_ADM</strong>: "'.$this->comment_fac_adm.'"<br />' : '';
      $comments .= (!empty($this->comment_mnl)) ? '<strong>MNL</strong>: "'.$this->comment_mnl.'"<br />' : '';
      $comments .= (!empty($this->comment_corp)) ? '<strong>CORP</strong>: "'.$this->comment_corp.'"<br />' : '';
      return $comments;
    }
    /**
     *  Flags a notice as needing attention when its x days old from creation
     *  @params string Defaults to 2 days old
     **/              
    public function needsAttention(){
      $diff = time() - strtotime($this->timestamp);
      $days_ago = floor($diff / (60 * 60 * 24));
      return $days_ago > WorkflowChangeNotice::$FLAG_DAYS;
    }
    
    /**
     *  Data provider for the homepage notice list
     *
     **/              
    public function getRequestsNeedingApproval(){
      $criteria = new CDbCriteria;
      
      $criteria->with = 'employmentProfile';
      
      //filters
      //only those which are not approved, declined or cancelled
      $criteria->addNotInCondition('t.status',array(self::$APPROVED,self::$DECLINED,self::$CANCELLED));
      
      // get only those facilities to which the user is assigned
      $criteria->addInCondition('employmentProfile.facility_id',Yii::app()->user->getState('hr_facility_handled_ids'));

      // get only those that's routed to user's group
      //$criteria->compare('t.processing_group',Yii::app()->user->getState('hr_group'));
    
      $criteria->order = 't.status asc, t.notice_type desc, t.timestamp asc'; 
    
      return new CActiveDataProvider($this,array(
        'criteria' => $criteria,
        'pagination'=>array(
          'pageSize'=>10
        ),
      ));
    }
   
   public function resetSignatures(){
      $null_ko = new CDbExpression('NULL');
      switch($this->status){
        case self::$NEW:
          //$this->bom_id = $this->fac_adm_id = $this->mnl_id = $this->corp_id = 0;
          $this->decision_bom = $this->decision_fac_adm = $this->decision_mnl = $this->decision_corp = 0;
          //$this->comment_bom = $this->comment_fac_adm = $this->comment_mnl = $this->comment_corp = $null_ko;
          //$this->attachment_bom = $this->attachment_fac_adm = $this->attachment_mnl = $this->attachment_corp = $null_ko;
          $this->timestamp_bom_signed = $this->timestamp_fac_adm_signed = $this->timestamp_mnl_signed = $this->timestamp_corp_signed = $null_ko;
        break;
        case self::$WAITING:
          if($this->processing_group == 'CORP'){
            //$this->corp_id = 0;
            $this->decision_corp = 0;
            //$this->comment_corp = $null_ko;
            $this->timestamp_corp_signed =  $null_ko;
          }
          if($this->processing_group == 'MNL'){
            //$this->mnl_id = $this->corp_id = 0;
            $this->decision_mnl = $this->decision_corp = 0;
            //$this->comment_mnl = $this->comment_corp = $null_ko;
            //$this->attachment_mnl = $this->attachment_corp = $null_ko;
            $this->timestamp_mnl_signed = $this->timestamp_corp_signed = $null_ko;
          }
          if($this->processing_group == 'FAC_ADM'){
            //$this->fac_adm_id = $this->mnl_id = $this->corp_id = 0;
            $this->decision_fac_adm = $this->decision_mnl = $this->decision_corp = 0;
            //$this->comment_fac_adm = $this->comment_mnl = $this->comment_corp = $null_ko;
            //$this->attachment_fac_adm = $this->attachment_mnl = $this->attachment_corp = $null_ko;
            $this->timestamp_fac_adm_signed = $this->timestamp_mnl_signed = $this->timestamp_corp_signed = $null_ko;
          }
        break;
      }   
   }
   
   public function needsEndorsement(){
    //return ($this->status == self::$NEW and $this->processing_group == 'BOM') or ($this->status == self::$WAITING and $this->processing_group == 'CORP');
    switch($this->processing_group){
      case 'BOM':
      case 'FAC_ADM':
        return $this->status == self::$NEW;
      break;
      case 'CORP':
        if (Yii::app()->user->getState('hr_group') != 'CORP') return false;
        return $this->status == self::$WAITING;
      break;
      default: return false;
    }
   }
   
   public function setDecision(){
      //Yii::log('DECISION: '.$this->decision,'error','app');
      switch($this->decision){
        case 'approve': 
          //echo 'approve!' ; 
          $this->is_approved = '1';
          $this->routeToGroup();
          $this->setSignee(); 
          $this->setStatus(); 
        break;
        case 'decline': 
          //echo 'decline!' ; 
          $this->is_approved = '0'; 
          $this->setSignee();
          $this->setStatus(); 
        break;
        case 'process': 
          //echo 'process!' ; 
          //$this->setStatus('PROCESS_ONLY');
          $this->setSignee();
          $this->status = self::$PROCESSING;
          $this->processing_user = Yii::app()->user->getState('id');
        break;
      }
   }
 
   public function isSignable(){
    switch($this->status){
      case self::$APPROVED: case self::$DECLINED: return false;
      default: return (Yii::app()->user->getState('hr_group') == $this->processing_group);
    }
   }
   
  public function parseComment($comment){
    if(empty($comment)) return '';
    $com = explode('|',$comment);
    $words = '';
//     foreach($com as $i=>$line){
//       $words .= ($i == 0) ? '<p>'.$line.'</p>' : '<small class="muted">'.$line.'</small>';
// 
//     }
    $words = $com[0];
    return $words;   
  }
  
  public function getStatus(){
    switch($this->status){
      case self::$WAITING: // warning
        return "<h4 class='alert alert-warning text-center'>$this->status on $this->processing_group</h4>";
      break;
      case self::$PROCESSING: // info
        return (!empty($this->processingUser->user_id)) ? "<h4 class='alert alert-info text-center'>".$this->processingUser->user->getFullName()." of $this->processing_group group is $this->status</h4>" : "<h4 class='alert alert-info text-center'>$this->processing_group is $this->status</h4>";
      break;
      case self::$APPROVED: // success
        return "<h4 class='alert alert-success text-center'>$this->status</h4>";
      break;
      case self::$DECLINED: // error
        return "<h4 class='alert alert-error text-center'>$this->status</h4>";
      break;
      default: return "<h4 class='alert alert-warning text-center'>$this->status</h4>";
    }
  }
  
  public function afterFind(){
    $this->facility = Facility::model()->find("idFACILITY = '".$this->employmentProfile->facility_id."'")->acronym;
    $emp_id = ($this->profile_id != 0) ?  $this->profile_id : $this->personalProfile->emp_id;
    $this->comments = $this->getLastGroupComment();
    $this->corp_id = User::getName($this->corp_id);
    $this->setWaitingPeriod();    
    return parent::afterFind();                  
  }
  
  private function setWaitingPeriod(){
	  $base_timestamp = 0;
	  switch($this->processing_group){
		  case 'BOM': $base_timestamp = $this->timestamp; break;
		  case 'FAC_ADM': $base_timestamp = $this->timestamp_bom_signed;  break;
		  case 'MNL': $base_timestamp = $this->timestamp_fac_adm_signed;  break;
		  case 'CORP': $base_timestamp = $this->timestamp_mnl_signed;  break;
	  }
	  $this->created_days_ago = abs(time() - strtotime($base_timestamp));
	  if($this->created_days_ago >= 86400){ //days
		$this->created_days_ago = floor($this->created_days_ago / 86400).' day(s) ago';
	  }elseif($this->created_days_ago >= 3600){
		$this->created_days_ago = floor($this->created_days_ago / 3600).' hour(s) ago';  
	  }elseif($this->created_days_ago >= 60){
		$this->created_days_ago = floor($this->created_days_ago / 60).' minute(s) ago';  
	  }else{
		$this->created_days_ago = $this->created_days_ago.' seconds ago';  
	  }
  }
  
  private function getLastGroupComment(){    
    switch($this->processing_group){
      case 'BOM': case 'FAC_ADM':
        return 'BOM: '.$this->getUserComment($this->comment_bom);
      break;
      case 'MNL':
        return 'FAC_ADM: '.$this->getUserComment($this->comment_fac_adm);
      break;
      case 'CORP':
        return ($this->status == self::$WAITING) ? 'MNL: '.$this->getUserComment($this->comment_mnl) : 'CORP: '.$this->getUserComment($this->comment_corp); 
      break;
      default: return "<small>BOM: '".$this->comment_bom."'<br>FAC_ADM: '".$this->comment_fac_adm."'<br>MNL: '".$this->comment_mnl."'<br>CORP: '".$this->comment_corp."'<br></small>"; 
    }
  }
  
  private function getUserComment($comment){
    $comment = explode('|',$comment);
    return isset($comment[0]) ? $comment[0] : '-';    
  } 
  
  public function setEffectiveDate($employment=null,$payroll=null,$employment_changes=array(),$payroll_changes=array()){
    return true;
    switch($this->notice_type){
      case 'NEW_HIRE':
      case 'RE_HIRE':
        $this->effective_date = $employment->date_of_hire;
      break ;
      case 'CHANGE':
        // pto
        if(!empty($payroll_changes) and array_key_exists('is_pto_eligible',$payroll_changes)){
          $this->effective_date = $payroll->pto_effective_date;  
        }
        // rate 
        if(!empty($payroll_changes) and (array_key_exists('rate_proposed',$payroll_changes) or  array_key_exists('rate_approved',$payroll_changes))){
          $this->effective_date = $payroll->rate_effective_date;  
        }
        // default if changed is rate_effective_date
        $this->effective_date = $payroll->rate_effective_date;   
      break ;
      case 'TERMINATED':
        $this->effective_date = $employment->date_of_termination;
      break ;
      default:
    }
  }
  
  public static function hasActiveNotice($emp_id){
    $active = true;
    $c = new CDbCriteria;
    $c->join = 'left outer join hr_employee_personal personal on personal.id = t.personal_profile_id';
    $c->compare('personal.emp_id', $emp_id);
    $c->addNotInCondition('status', array('APPROVED','DECLINED','CANCELLED'));
    $exists = WorkflowChangeNotice::model()->exists($c);
    $active = $exists;    
    return $active;
  }
  
  public static function getHistory($emp_id=''){
    $c = new CDbCriteria;
    $c->join = "left outer join hr_employee_personal personal on personal.id = t.personal_profile_id";
    $c->compare('personal.emp_id',$emp_id);
    $c->order = 'timestamp desc';
    return new CActiveDataProvider(new WorkflowChangeNotice, array(
      'criteria'=>$c,
    ));
  }
  
  
  public function beforeSave(){
    if($this->isNewRecord){
      $this->timestamp = new CDbExpression('NOW()'); 
      $this->summary_of_changes = (!empty($this->summary_of_changes)) ? serialize($this->summary_of_changes) : serialize(array());
      $this->reason = $this->reason.' - '.$this->reason_other;
    }   
    $this->last_updated_timestamp = new CDbExpression('NOW()');
    return parent::beforeSave();
  }
  
  public function beforeValidate(){
    
    return parent::beforeValidate();
  }
  
  
  // called during applicant self-service, staff registration, and new workflows
  public static function initiate($type='NEW_HIRE',$profiles=array(),$comment=''){
     $workflow = new WorkflowChangeNotice('create');
     $workflow->notice_type = $type;
     $workflow->profile_id = $profiles['emp_id'];
     $workflow->personal_profile_id = $profiles['personal_profile_id'];
     $workflow->employment_profile_id = $profiles['employment_profile_id'];
     $workflow->payroll_profile_id = $profiles['payroll_profile_id'];
     $workflow->is_approved = '1'; // assume approval so that the current user can push this to next group
     $workflow->effective_date = $profiles['date_of_hire']; 
     $workflow->comment = $comment;
     $frm = new CActiveForm;
     $initiator = Yii::app()->user->getState('id');
     $workflow->initiated_by = empty($initiator) ? '0' : $initiator;
     $workflow->setStatus();
     $workflow->routeToGroup();
     $workflow->setSignee();
     if($workflow->save()){        
        $workflow->notifyGroup();
        self::log($profiles['emp_id'], $type, 'Created ID '.$workflow->id ,$workflow->status, $workflow->processing_group, '', $comment);
     }else{
        self::log($profiles['emp_id'], $type, 'Failed to create: '.print_r($frm->errorSummary($workflow),true) ,$workflow->status, $workflow->processing_group, '', $comment);   
     } 
  }
  
  public function notifyGroup(){
    $c = new CDbCriteria;
    $c->select = 'username';
    $c->join = 'left outer join hr_user hu on hu.user_id = t.idUSER';
    
    // while notice is still under approval process, only notify the next processing group
    switch($this->status){
      case self::$NEW : case self::$WAITING :  
        $c->compare('hu.group',$this->processing_group);
      break;
      case self::$PROCESSING :  case self::$APPROVED :  case self::$DECLINED : 
        $c->addInCondition('hu.group',array('BOM','FAC_ADM','MNL'));
      break; 
    }

    // only notify people assigned to employee's facility
    $c->compare('hu.facility_handled_ids',$this->employmentProfile->facility_id,true);    

    $users = User::model()->findAll($c);
    foreach($users as $user){
      $to = $user->username;
      $subject = Yii::app()->name.' | '.$this->id.' | '.$this->employmentProfile->facility->acronym.' | '.$this->notice_type.' | '.$this->employmentProfile->positionCode->name.' | '.$this->status;
      //$subject = Yii::app()->name.' | '.$this->notice_type.' | '.$this->status.' | Workflow ID '.$this->id;
      $link = Yii::app()->createAbsoluteUrl('hr/workflowchangenotice/view/',array('id'=>$this->id));
      $message = "<p>Hi,</p><p></p><p>Your workflow request has been updated:</p>
        <ul>
          <li>ID    : $this->id</li>
          <li>STATUS: $this->status</li>
          <li>TYPE  : $this->notice_type</li>        
          <li>LINK  : $link</li>
        </ul>        
      ";
      Helper::queueMail($to,$subject,$message);
    }  
  }
  
  public static function log($emp_id, $type, $action ,$status, $to_group, $to_user='', $comment){  
    $log_message = "WORKFLOW: $action $type for Employee Id $emp_id by user ".Yii::app()->user->name.' | User Comment: '.$comment;
    Yii::log($log_message,'info','app');  
  }
  
  public function setWorkflow(){
    switch($this->scenario){
      case 'create' : 
      case 'workflow_new':

      break;
      case 'update' : 
        throw new CHttpException(400,'Function not yet implemented');
      break;
      case 'override' : 
        throw new CHttpException(400,'Function not yet implemented');
      break;
      case 'process' : 
        throw new CHttpException(400,'Function not yet implemented');
      break;                         
    }      
  }
  
  public function setSignee(){
    $user_group = Yii::app()->user->getState('hr_group');
    //Yii::log('USERGROUP: '.$user_group,'error','app');
    switch($user_group){
      case HrUser::$BOM :
        $this->bom_id = Yii::app()->user->getState('id');
        $this->timestamp_bom_signed = new CDbExpression('NOW()');
        $this->decision_bom = ($this->scenario != 'process') ? $this->is_approved  : new CDbExpression('NULL');
        $this->comment_bom = $this->comment; 
        $this->attachment_bom = isset($this->attachment) ? $this->attachment : '';        
      break; 
      case HrUser::$FAC_ADM : 
        $this->fac_adm_id = Yii::app()->user->getState('id');
        $this->timestamp_fac_adm_signed = new CDbExpression('NOW()');
        $this->decision_fac_adm = ($this->scenario != 'process') ? $this->is_approved  : new CDbExpression('NULL');
        $this->comment_fac_adm = $this->comment; 
        $this->attachment_fac_adm = isset($this->attachment) ? $this->attachment : '';        
      break;
      case HrUser::$MNL : 
        $this->mnl_id = Yii::app()->user->getState('id');
        $this->timestamp_mnl_signed = new CDbExpression('NOW()');
        $this->decision_mnl = ($this->scenario != 'process') ? $this->is_approved : new CDbExpression('NULL');
        $this->comment_mnl = $this->comment; 
        $this->attachment_mnl = isset($this->attachment) ? $this->attachment : '';        

      break;
      case HrUser::$CORP  :
        $this->corp_id = Yii::app()->user->getState('id');
        $this->timestamp_corp_signed = new CDbExpression('NOW()');
        $this->decision_corp = ($this->scenario != 'process') ? $this->is_approved : new CDbExpression('NULL');
        $this->comment_corp = $this->comment; 
        $this->attachment_corp = isset($this->attachment) ? $this->attachment : '';
        if($this->is_approved == '1'){
          $this->approveProfiles();
        } 
        // Yii::log('DEBUG: '.print_r($this->attributes,true),'error','app');      
      break;        
    }  
  }
  
  private function approveProfiles(){
      // approve new profiles
      EmployeePersonalInfo::model()->updateByPk($this->personal_profile_id,array('is_approved'=>'1'));
      EmployeeEmployment::model()->updateByPk($this->employment_profile_id,array('is_approved'=>'1'));
      EmployeePayroll::model()->updateByPk($this->payroll_profile_id,array('is_approved'=>'1'));
      
      if($this->notice_type == 'NEW_HIRE') return; // don't proceed to updating the main profile since its the seed profile
  
      $emp_id = EmployeePersonalInfo::model()->findByPk($this->personal_profile_id)->emp_id;    
      
      // update the main profile
      $employee = Employee::model()->findByPk($emp_id);
      if($this->profile_id == '0'){
        $archive = EmployeeBasicInfoArchive::model()->find(array(
          'condition'=>"emp_id = '$emp_id'",
          'order'=>'timestamp desc'  
        ));
        
        $tmp = clone $employee;
        // archive -> main profile
        $employee->last_name = $archive->last_name;
        $employee->first_name = $archive->first_name;
        $employee->middle_name = $archive->middle_name;
        $employee->photo = $archive->photo;
        $employee->timestamp = $archive->timestamp;
        // archive <- tmp
        $archive->last_name = $tmp->last_name;
        $archive->first_name = $tmp->first_name;
        $archive->middle_name = $tmp->middle_name;
        $archive->photo = $tmp->photo;
        $archive->timestamp = $tmp->timestamp;
        
        if(!$archive->save(false)){
            //Yii::log('YAWAAAAAAAA','error','app');
        }else{
            //Yii::log('KANA BA','error','app');
        }
      }
      
      $employee->active_personal_id = $this->personal_profile_id;
      $employee->active_employment_id = $this->employment_profile_id;
      $employee->active_payroll_id = $this->payroll_profile_id;
      $employee->save(false);
      
  }
  
  public function setStatus($action=''){
    // if action is process only, simply flag it as processing
    if($action=='PROCESS_ONLY'){
      $this->status = self::$PROCESSING;
      return;  
    } 
    
    $user_group = Yii::app()->user->getState('hr_group');
    switch($user_group){
      case HrUser::$BOM : 
      case HrUser::$MNL : 
      case HrUser::$FAC_ADM :
          $this->status = ($this->is_approved == '1') ? self::$WAITING : self::$DECLINED;
      break;
      case HrUser::$CORP  :
        $this->status = ($this->is_approved == '1') ? self::$APPROVED : self::$DECLINED;
        if($this->isNewRecord and $this->is_approved == '1'){
          $this->approveProfilesOnRegistration();
        }
      break;        
      default: $this->status = self::$NEW; // set all as new
    }  
  }
  
  private function approveProfilesOnRegistration(){
    EmployeePersonalInfo::model()->updateByPk($this->personal_profile_id, array('is_approved'=>'1'));
    EmployeeEmployment::model()->updateByPk($this->employment_profile_id, array('is_approved'=>'1'));
    EmployeePayroll::model()->updateByPk($this->payroll_profile_id, array('is_approved'=>'1'));
  }
  
  public function routeToGroup(){
    $user_group = Yii::app()->user->getState('hr_group');
    switch($user_group){
      case HrUser::$BOM :
        $this->processing_group = HrUser::$FAC_ADM;
      break;
      case HrUser::$FAC_ADM :
        $this->processing_group = HrUser::$MNL;
      break;
      case HrUser::$MNL :
        $this->processing_group = HrUser::$CORP;
      break;
      case HrUser::$CORP  :
        $this->processing_group = HrUser::$CORP; // terminate
      break;        
      default: $this->processing_group = HrUser::$BOM; // all route to BOM
    }  
  }
  
  public static function getList(){
//     return array(
//       'NEW_HIRE'=>'NEW_HIRE',
//       'CHANGE'=>'CHANGE',
//       'RE_HIRE'=>'RE_HIRE',
//       'TERMINATED'=>'TERMINATED',
//     );
    return ZHtml::enumItem(new WorkflowChangeNotice,'notice_type');
  }
  
  /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return WorkflowChangeNotice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hr_workflow_change_notice';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//create
      array('initiated_by, profile_id, personal_profile_id, employment_profile_id , payroll_profile_id, notice_type, status, processing_group','required','on'=>'create'),
         
      //sign
      array('comment, decision, attachment','safe','on'=>'sign'), 
      array('decision', 'validateDecision', 'on'=>'sign'),
      array('comment','validateComment', 'on'=>'sign'),    

      //new
      array('notice_type','required','on'=>'new'),
      array('reason','validateReason','on'=>'new'),
      array('notice_sub_type','validateSubType','on'=>'new'),  

      // ovveride
      array('status, processing_group, decision, comment','required','on'=>'override'),
      array('status, processing_group, decision, comment','safe','on'=>'override'),
      array('status', 'validateStatus', 'on'=>'override'),
      
      //attach
      array('docs', 'validateDocs', 'on'=>'attach, new'),
                                     
			array('initiated_by, processing_user, profile_id, personal_profile_id, employment_profile_id, payroll_profile_id, bom_id, fac_adm_id, mnl_id, corp_id, decision_bom, decision_fac_adm, decision_mnl, decision_corp', 'numerical', 'integerOnly'=>true),
			array('notice_type', 'length', 'max'=>10),
			array('status', 'length', 'max'=>10),
			array('processing_group', 'length', 'max'=>7),
			array('attachment_bom, attachment_fac_adm, attachment_mnl, attachment_corp', 'length', 'max'=>128),
			array('comment, reason_other, docs', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('effective_from, effective_to, facility, position, employee, id, initiated_by, notice_type, notice_sub_type, reason ,status, processing_group, processing_user, profile_id, personal_profile_id, employment_profile_id, payroll_profile_id, bom_id, fac_adm_id, mnl_id, corp_id, timestamp_bom_signed, timestamp_fac_adm_signed, timestamp_mnl_signed, timestamp_corp_signed, decision_bom, decision_fac_adm, decision_mnl, decision_corp, comment_bom, comment_fac_adm, comment_mnl, comment_corp, attachment_bom, attachment_fac_adm, attachment_mnl, attachment_corp, timestamp', 'safe', 'on'=>'search'),
		);
	}
  
  public function validateSubType(){
    if($this->notice_type == 'CHANGE' and empty($this->notice_sub_type)){
      $this->addError('notice_sub_type','Notice sub-type is required.');
    }
  }
  
  public function validateDocs(){
    $c = new CDbCriteria;
    $c->compare('notice_type',$this->notice_type);
    if(!empty($this->notice_sub_type)){
      $c->compare('notice_sub_type',$this->notice_sub_type);
    }
    $docs_required = HrDocuments::model()->findAll($c);
    foreach($docs_required as $doc){
      if(empty($this->docs[$doc->document])){
        $this->addError($this->docs[$doc->document],$doc->document.' is required.');
      }
    }
  }
  
  public function validateReason(){
    if($this->reason == 'Other' and empty($this->reason_other)){
      $this->addError('reason_other','Please provide a reason other than the ones listed above.');
    } 
  }
  
  public function validateStatus(){
    switch($this->status){
      case self::$NEW:
        if($this->processing_group != 'BOM'){
          $this->addError('status','When status is NEW, this notice should be routed to the facility BOM.');
          $this->addError('processing_group','This notice should be routed to the facility BOM.');
        }
      break;
      case self::$PROCESSING:

      break;
      case self::$WAITING:
        if($this->processing_group == 'BOM'){
          $this->addError('status','When status is WAITING, this notice should be routed to one of the following: FAC_ADM, MNL, CORP.');
          $this->addError('processing_group','This notice should be routed to one of the following: FAC_ADM, MNL, CORP.');
        }
      break;
      case self::$APPROVED:
        if($this->processing_group != 'CORP'){
          $this->addError('status','When status is APPROVED, this notice should route to CORP.');
          $this->addError('processing_group','This notice should be routed to CORP.');
        }
        if($this->decision != 'approve'){
          $this->addError('decision','Inconsistent decision.');
        }
      break;
      case self::$DECLINED:
        if($this->processing_group != 'CORP'){
          $this->addError('status','When status is DECLINED, this notice should route to CORP.');
          $this->addError('processing_group','This notice should be routed to CORP.');
        }
        if($this->decision != 'decline'){
          $this->addError('decision','Inconsistent decision.');
        }
      break;
      case self::$CANCELLED:
        
      break;
    }  
  }
  
  public function validateDecision(){
    if($this->decision == 'DECLINED' and empty($this->comment)){
      $this->addError('comment','A comment is required when a notice is declined.');
    }
  }
  
  public function validateComment(){
    //Yii::log('DEBUGrrr: '.print_r($this->attributes, true),'error','app');
    if($this->decision == 'decline' and empty($this->comment)){
      $this->addError('comment','A comment is required.');
    }
  }
   
	/**
	 * @return array relational rules.
	 */
	public function relations()
  {
    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
    return array(
        'corporate' => array(self::BELONGS_TO, 'User', 'corp_id'),
        'corp' => array(self::BELONGS_TO, 'User', 'corp_id'),
        'profile' => array(self::BELONGS_TO, 'Employee', 'profile_id'),
        'processingUser' => array(self::BELONGS_TO, 'HrUser', 'processing_user'),
        'bom' => array(self::BELONGS_TO, 'User', 'bom_id'),
        'facAdm' => array(self::BELONGS_TO, 'User', 'fac_adm_id'),
        'mnl' => array(self::BELONGS_TO, 'User', 'mnl_id'),
        'initiatedBy' => array(self::BELONGS_TO, 'User', 'initiated_by'),
        'personalProfile' => array(self::BELONGS_TO, 'EmployeePersonalInfo', 'personal_profile_id'),
        'employmentProfile' => array(self::BELONGS_TO, 'EmployeeEmployment', 'employment_profile_id'),
        'payrollProfile' => array(self::BELONGS_TO, 'EmployeePayroll', 'payroll_profile_id'),
    );
}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Notice ID',
			'initiated_by' => 'Prepared By',
			'notice_type' => 'Notice Type',
			'status' => 'Status',
      'effective_date' => 'Notice Effective Date',
			'processing_group' => 'Processing Group',
			'processing_user' => 'Processing User',
			'profile_id' => 'Employee',
			'personal_profile_id' => 'Personal Profile',
			'employment_profile_id' => 'Employment Profile',
			'payroll_profile_id' => 'Payroll Profile',
			'bom_id' => 'Signed',
			'fac_adm_id' => 'Signed',
			'mnl_id' => 'Signed',
			'corp_id' => 'Signed',
			'timestamp_bom_signed' => 'Timestamp',
			'timestamp_fac_adm_signed' => 'Timestamp',
			'timestamp_mnl_signed' => 'Timestamp',
			'timestamp_corp_signed' => 'Timestamp',
			'decision_bom' => 'Decision',
			'decision_fac_adm' => 'Decision',
			'decision_mnl' => 'Decision',
			'decision_corp' => 'Decision',
			'comment_bom' => 'Comment',
			'comment_fac_adm' => 'Comment',
			'comment_mnl' => 'Comment',
			'comment_corp' => 'Comment',
			'bom_attachment' => 'Attachment',
			'attachment_fac_adm' => 'Attachment',
			'attachment_mnl' => 'Attachment',
			'attachment_corp' => 'Attachment',
			'timestamp' => 'Created',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function getActiveRequests()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

    $criteria->join = '';
    //$criteria->join .= " left outer join hr_employee employee on employee.emp_id = t.profile_id";
    $criteria->join .= " left outer join hr_employee_employment employment on employment.id = t.employment_profile_id";
    //$criteria->join .= " left outer join user on user.idUSER = t.initiated_by";
    //$criteria->join .= " left outer join hr_position position on position.code = employment.position_code";
    //$criteria->join .= " left outer join facility on facility.idFACILITY = employment.facility_id";

    //parent
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.initiated_by',$this->initiated_by);
		$criteria->compare('t.notice_type',$this->notice_type);
    $criteria->compare('t.notice_sub_type',$this->notice_sub_type);
    $criteria->compare('t.bom_id',$this->bom_id);
		$criteria->compare('t.fac_adm_id',$this->fac_adm_id);
		$criteria->compare('t.mnl_id',$this->mnl_id);
    $criteria->compare('t.corp_id',$this->corp_id);
		$criteria->compare('t.processing_group',$this->processing_group);
		$criteria->compare('t.processing_user',$this->processing_user);
    $criteria->compare('t.reason',$this->reason, true);

	//restrict who can see admins and dons
    if(!AccessRules::canSee('rate_approved')){
		$criteria->addCondition("employment.position_code != 25");//admin
		$criteria->addCondition("employment.position_code != 6");//don
	}

    if(!empty($this->effective_from) and !empty($this->effective_to)){
      $criteria->addBetweenCondition('effective_date',$this->effective_from,$this->effective_to);
    }elseif(!empty($this->effective_from) and empty($this->effective_to)){
      $criteria->addBetweenCondition('effective_date',$this->effective_from,$this->effective_from);  
    }elseif(empty($this->effective_from) and !empty($this->effective_to)){
      $criteria->addBetweenCondition('effective_date',$this->effective_to,$this->effective_to);  
    }

    if (!empty($this->status) and !empty($this->status[0]))
      $criteria->addInCondition('t.status',$this->status);
 

                                        
    //neighbors
    $criteria->compare('employment.facility_id',$this->facility);
    //$criteria->compare('employment.position_code',$this->position);
    //$criteria->compare('employee.emp_id',$this->employee);
    
    // filter
    // 1. show only employee notices per user's assigned facilities for non-admin users
    if(Yii::app()->user->getState('hr_group') != 'CORP' or Yii::app()->user->getState('hr_group') != 'SYS_ADM')
      $criteria->addInCondition('employment.facility_id',Yii::app()->user->getState('hr_facility_handled_ids'));
    

    //Yii::log('CDBCRIT: '.print_r($criteria,true),'info','app');
    //Yii::log('SIZE: '.print_r($this->status,true),'info','app'); 

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
      'sort'=>array(
        'defaultOrder'=>'status asc, last_updated_timestamp desc',        
      ),
		));
	}
  
  // if something has changed to the basic info, it is temporarily stored to hr_employee_basic_archive. 
  // the workflow profile_id field would be marked zero, which is a flag that the info should be pulled out from
  //  hr_employee_basic_archive instead.
  public function getProposedBasic(){    
    return ($this->profile_id != '0') ? $this->profile : EmployeeBasicInfoArchive::model()->find(array(
      'condition'=>"emp_id = '".$this->personalProfile->emp_id."'",
      'order'=>'timestamp desc',
    ));  
  }
 
  public static function renderActionColumn($model,$row,$controller){
    $controller->widget('bootstrap.widgets.TbButtonGroup', array(
        'type'=>'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'dropup'=>true,
        'buttons'=>array(
           array('label'=>'Actions', 'items'=>array(
             array('label'=>'WORKFLOW'),
             array('label'=>'View Details', 'url'=>array('hr/workflowchangenotice/view','id'=>$model->id),'icon'=>'eye-open'),
             array('label'=>'Print Preview', 'url'=>array('hr/workflowchangenotice/print','id'=>$model->id),'icon'=>'print','linkOptions'=>array('target'=>'_blank')),
             //'---',
             //array('label'=>'DECISION'),
             //array('label'=>'Process', 'url'=>array('hr/workflowchangenotice/process','id'=>$model->id),'icon'=>'cog','linkOptions'=>array('submit'=>array('process','id'=>$model->id),'confirm'=>'Are you sure you want to PROCESS this notice?')),
             //array('label'=>'Approve', 'url'=>array('hr/workflowchangenotice/approve','id'=>$model->id),'icon'=>'thumbs-up','linkOptions'=>array('submit'=>array('approve','id'=>$model->id),'confirm'=>'Are you sure you want to APPROVE this notice?')),
             //array('label'=>'Decline', 'url'=>array('hr/workflowchangenotice/decline','id'=>$model->id),'icon'=>'thumbs-down','linkOptions'=>array('submit'=>array('decline','id'=>$model->id),'confirm'=>'Are you sure you want to DECLINE this notice?')),
             //'---',
             //array('label'=>'ADMIN'),
             //array('label'=>'Override', 'url'=>array('hr/workflowchangenotice/override','id'=>$model->id),'icon'=>'pencil','linkOptions'=>array('submit'=>array('override','id'=>$model->id),'confirm'=>"This will reset the signatures and timestamp of the workflow. Are you sure you want to OVERRIDE this notice?")),
             //array('label'=>'Cancel', 'url'=>array('hr/workflowchangenotice/cancel','id'=>$model->id),'icon'=>'remove','linkOptions'=>array('submit'=>array('cancel','id'=>$model->id),'confirm'=>'Are you sure you want to CANCEL this notice?')),
            ),
            'icon'=>'question-sign white',
            'htmlOptions'=>array('rel'=>'tooltip','title'=>'What do you want to do?'),
          ),
        ),
    )); 
  }
  
  
  
  
}
