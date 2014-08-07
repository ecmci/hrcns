<?php

/**
 * This is the model class for table "tar_log".
 *
 * The followings are the available columns in table 'tar_log':
 * @property integer $case_id
 * @property string $control_num
 * @property string $resident
 * @property string $medical_num
 * @property string $dx_code
 * @property string $admit_date
 * @property string $type
 * @property string $requested_dos_date_from
 * @property string $requested_dos_date_thru
 * @property string $applied_date
 * @property string $denied_deferred_date
 * @property string $approved_modified_date
 * @property string $backbill_date
 * @property double $aging_amount
 * @property string $notes
 * @property integer $is_closed
 * @property string $reason_for_closing
 * @property string $created_timestamp
 * @property integer $approved_care_id
 * @property integer $status_id
 * @property integer $created_by_user_id
 * @property integer $facility_id
 * @property string $resident_status
 *
 * The followings are the available model relations:
 * @property TarActivityTrail[] $tarActivityTrails
 * @property TarAlerts[] $tarAlerts
 * @property TarApprovedCare $approvedCare
 * @property TarStatus $status
 * @property TarUser $createdByUser
 * @property Facility $facility
 * @property TarProcedureChecklist[] $tarProcedureChecklists
 */
class TarLog extends CActiveRecord
{
	public $age_in_days, $last_activity, $data_struct_checklists, $data_struct_alerts, $reason_for_closing, $message, $send_email, $send_email_to;
  public $DB_DATE_FORMAT = 'Y-m-d';
  public $HUMAN_DATE_FORMAT = 'm/d/Y';
  public $HUMAN_DATETIME_FORMAT = 'm/d/Y h:i A';
  public $is_cron_trigerred = false;
  
  //hard coded status IDs
  public static $STATUS_TO_BE_APPLIED = '1';
  public static $STATUS_UNDER_REVIEW = '2';
  public static $STATUS_DEFERRED = '3';
  public static $STATUS_DENIED = '4';
  public static $STATUS_APPROVED = '5';
  
  //hard coded thresholds
  public static $NORMAL = '21';
  public static $WARNING = '30';
  public static $CRITICAL = '3';
  
    
  
  
  /**************** CRON JOBS ***************/  
  
  /**
   * WEEKLY: report of all open cases
   */
  public function reportOpenCases()
    {
        $criteria=new CDbCriteria;
        $criteria->with = array('status','facility');

        $criteria->compare('created_by_user_id',$this->created_by_user_id);
        $criteria->compare('facility_id',$this->facility_id);
        $criteria->compare('is_closed','0');
        
        $criteria->order = "requested_dos_date_from asc, status_id desc";

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>false
        ));
    }           
  
  /**
   * DAILY: For all open, process configured alerts
   */
  public function processCustomAlerts(){
    $cases = self::model()->findAll("is_closed = 0");
    if($cases){
      foreach($cases as $case){
        $cfg_alerts = CJSON::decode($case->alerts->data);
        if($cfg_alerts){
          foreach($cfg_alerts as $cfg_alert){
            if( ($cfg_alert['status'] == $case->status_id) and ( $case->age_in_days >= $cfg_alert['age']) ){
              //email
              $subject = "TAR ".$case->condition." Alert | Case #".$case->case_id." Needs Your Attention";
              $message = "TAR Case # ".$case->case_id." is ".$case->age_in_days." days old and it is still on ".$case->status->name." status.\n\n";
              if(!empty($cfg_alert['email'])){
                foreach($cfg_alert['email'] as $email){
                  Helper::queueMail($email,$subject,$message);
                }
              }
            }
          }  
        }  
      }
    }   
  }     
  
  
  /**
   *  DAILY: For all open cases, update the alert thresholds;
   *  Should be run once daily preferrably at 12:05AM    
   */
  public function updateThreshold(){
    $open_cases = self::model()->findAll("is_closed = 0");
    if($open_cases){
      foreach($open_cases as $open_case){
        $open_case->condition = $open_case->getUrgencyLevel();
        $open_case->is_cron_trigerred = true;
        $open_case->save(false);  
      }
    }
  }     
  
  
  /**
   *  DAILY:  Check for open cases which are not 'Approved' and create a summary for each status per urgency and send IM/email to its requester 
   *  The summary is sent as message and email. 
   *  Should be run once daily preferrably at 12:05AM
   */
  public function summarizeOpenCases(){
    foreach(TarUser::model()->findAll() as $tar_user){
      $c = new CDbCriteria;
      $c->select = "t.condition, count( t.condition ) AS notes";
      $c->group = "t.condition";
      $c->compare('t.is_closed','0');
      $c->compare('t.created_by_user_id',$tar_user->id);
      $data = array(
        'Normal'=>'',
        'Warning'=>'',
        'Critical'=>'',
      );
      $cases = self::model()->findAll($c);
      if($cases){
        foreach($cases as $case){
          $data[$case->condition] = $case->notes;    
        }
        $subject = "TAR | Open Cases That Need Your Attention";
        $message = "Summary:\n\n";
        $message .= CHtml::link('Normal('.$data['Normal'].')',Yii::app()->createUrl('tar/log?TarLog[condition]=Normal')).', ';
        $message .= CHtml::link('Warning('.$data['Warning'].')',Yii::app()->createUrl('tar/log?TarLog[condition]=Warning')).', ';
        $message .= CHtml::link('Critical('.$data['Critical'].')',Yii::app()->createUrl('tar/log?TarLog[condition]=Critical'));        
  
        //message the creator
        $msg = new TarMessaging;
        $msg->from_user_id = TarUser::$SYS_ADM_ID;
        $msg->to_user_id = $tar_user->id;
        $msg->message = $subject.' '.$message;
        $msg->is_cron_triggered = true;
        $msg->save(false);
      }
    }  
  }
  
   /**************** CRON JOBS ***************/ 
  
    

  /**
   * Determine urgency levels
   * @return string Urgency Level   
   */     
  public function getUrgencyLevel(){
    switch($this->status_id){
      case self::$STATUS_TO_BE_APPLIED: 
      case self::$STATUS_UNDER_REVIEW:
        if($this->age_in_days >= 31){
          return 'Critical';
        }elseif($this->age_in_days >= 22){
          return 'Warning';
        }else{
          return 'Normal';
        }      
      break;
      case self::$STATUS_DEFERRED:
      case self::$STATUS_DENIED:
        $valid_time = strtotime($this->denied_deferred_date);
        if($valid_time){        
          $date_deferred_denied = new DateTime(date('Y-m-d',$valid_time));
          $date_today = new DateTime(date('Y-m-d',time()));
          $interval = $date_deferred_denied->diff($date_today);
          $deferred_denined_days_ago = $interval->days; 
          if($deferred_denined_days_ago > 3){
            return "Critical";
          }else{
            return "Normal";
          }  
        }else{
          return "Undetermined";
        }
      break;
      case self::$STATUS_APPROVED:
        $valid_time = strtotime($this->approved_modified_date);
        if($valid_time){        
          $date_approved = new DateTime(date('Y-m-d',$valid_time));
          $date_today = new DateTime(date('Y-m-d',time()));
          $interval = $date_approved->diff($date_today);
          $approved_days_ago = $interval->days; 
          if($approved_days_ago > 2){
            return "Critical";
          }else{
            return "Normal";
          }  
        }else{
          return "Undetermined";
        }
      break;
      default: return "Normal"; 
    }
  }
  
  /**
   * Override parent: Do stuff after find
   */
  public function afterFind(){
    //human format date fields
    $this->admit_date = strtotime($this->admit_date) ? date($this->HUMAN_DATE_FORMAT,strtotime($this->admit_date)) : '';
    $this->requested_dos_date_from = strtotime($this->requested_dos_date_from) ? date($this->HUMAN_DATE_FORMAT,strtotime($this->requested_dos_date_from)) : '';
    $this->requested_dos_date_thru = strtotime($this->requested_dos_date_thru) ? date($this->HUMAN_DATE_FORMAT,strtotime($this->requested_dos_date_thru)) : '';
    $this->denied_deferred_date = strtotime($this->denied_deferred_date) ? date($this->HUMAN_DATE_FORMAT,strtotime($this->denied_deferred_date)) : '';
    $this->approved_modified_date = strtotime($this->approved_modified_date) ? date($this->HUMAN_DATE_FORMAT,strtotime($this->approved_modified_date)) : '';
    $this->backbill_date = strtotime($this->backbill_date) ? date($this->HUMAN_DATE_FORMAT,strtotime($this->backbill_date)) : '';
    $this->applied_date = strtotime($this->applied_date) ? date($this->HUMAN_DATE_FORMAT,strtotime($this->applied_date)) : '';

    //calc age
    $this->calcAge();
    
    //get last activity
    $this->getLastActivity();

    return parent::afterFind();
  }
  
  /**
   *
   */
  private function getLastActivity(){
    $act = TarActivityTrail::model()->find(array(
      'condition'=>'log_case_id = '.$this->case_id,
      'order'=>'timestamp desc',  
    ));
    $this->last_activity = $act ? '<small>'.$act->message.'<br/>('.$act->timestamp.')</small>' : ''; 
  }      
  
  /**
   * Calculate age
   * @return int no. of days   
   */     
  private function calcAge(){
    $requested = new DateTime(date('Y-m-d',strtotime($this->requested_dos_date_from)));
    $today = new DateTime(date('Y-m-d',time()));
    $interval = $requested->diff($today);
    $this->age_in_days = $interval->days;
  }     
  
  
  /**
   * Override parent: do stuff before saving
   */
  protected function beforeSave(){
    // set fks and others
    $this->created_by_user_id = Yii::app()->user->getState('id');

    //db format date fields
    $this->admit_date = strtotime($this->admit_date) ? date($this->DB_DATE_FORMAT,strtotime($this->admit_date)) : new CDbExpression('NULL');
    $this->requested_dos_date_from = strtotime($this->requested_dos_date_from) ? date($this->DB_DATE_FORMAT,strtotime($this->requested_dos_date_from)) : new CDbExpression('NULL');
    $this->requested_dos_date_thru = strtotime($this->requested_dos_date_thru) ? date($this->DB_DATE_FORMAT,strtotime($this->requested_dos_date_thru)) : new CDbExpression('NULL');
    $this->denied_deferred_date = strtotime($this->denied_deferred_date) ? date($this->DB_DATE_FORMAT,strtotime($this->denied_deferred_date)) : new CDbExpression('NULL');
    $this->approved_modified_date = strtotime($this->approved_modified_date) ? date($this->DB_DATE_FORMAT,strtotime($this->approved_modified_date)) : new CDbExpression('NULL');
    $this->backbill_date = strtotime($this->backbill_date) ? date($this->DB_DATE_FORMAT,strtotime($this->backbill_date)) : new CDbExpression('NULL');
    $this->applied_date = strtotime($this->applied_date) ? date($this->DB_DATE_FORMAT,strtotime($this->applied_date)) : new CDbExpression('NULL');
    
    
    return parent::beforeSave();
  }
  
  /**
   * Override parent: do stuff after save
   */
  protected function afterSave(){
    //set default procedure
    if($this->isNewRecord){
      $this->setDefaultProcedures();
      $this->setDefaultAlerts();
    }elseif($this->scenario == 'update' and !$this->is_cron_trigerred){
      $this->updateChecklist();
      $this->updateAlerts();
    }else{
    
    }
    
    //set default alerts

    return parent::afterSave();
  }
  
  /***********************
   * Custom Methods 
   ***********************/
   
   /**
    * Send follow up to the creator
    */       
  public function followUp(){
    $mess = Yii::app()->user->getState('user').' said: '.$this->message;
    if(Yii::app()->user->getState('id') != $this->created_by_user_id){
      $message = new TarMessaging;
      $message->from_user_id = Yii::app()->user->getState('id');
      $message->to_user_id = $this->created_by_user_id;
      $message->message = $mess;
      $message->save(false);
    }
    
    if($this->send_email == '1'){
      Helper::queueMail($this->send_email_to,'TAR Activity | Case #'.$this->case_id, $mess);
    } 
  }
   
   /*
    * Close case
    */
  public function close(){
    $this->is_closed = '1';
    return $this;
  }     
    
  
  
  /**
   * Updates the checklist
   */
  private function updateAlerts(){
    $alerts = TarAlerts::model()->find("log_case_id = $this->case_id");
    $alerts->data = CJSON::encode($this->data_struct_alerts);
    if($alerts->save(false)){
      //Yii::log('Saved!','error','app');
    }else{
      //Yii::log('Not Saved!','error','app');
    }
  }
  
  /**
   * Updates the checklist
   */
  private function updateChecklist(){
    $checklist = TarProcedureChecklist::model()->find("log_case_id = $this->case_id");
    $checklist->data = CJSON::encode($this->data_struct_checklists);
    if($checklist->save(false)){
      //Yii::log('Saved!','error','app');
    }else{
      //Yii::log('Not Saved!','error','app');
    } 
  }        
  
  /**
   * Setup default alerts
   */
  private function setDefaultAlerts(){
    $ds_tpl = TarAlertsTemplate::model()->findByPk("1"); //default template
    $dstruct_tpl = empty($ds_tpl) ? array() : $ds_tpl->data_struct;
    $alerts = new TarAlerts;
    $alerts->data = CJSON::encode($dstruct_tpl);
    $alerts->log_case_id = $this->case_id;
    $alerts->alerts_tpl_id = $ds_tpl->id;
    $alerts->save(false);
  }            
  
  /**
   * Setup default procedures and checklist
   */
  private function setDefaultProcedures(){
    $data_struct_tpl = TarProcedureTemplate::model()->findByPk("1"); //default template
    $data_struct = empty($data_struct_tpl) ? array() : $data_struct_tpl->data_struct;
    $procedure = new TarProcedureChecklist;

    //insert checklist tracking
    foreach($data_struct as $i=>$ds){
      foreach($ds['checklists'] as $j=>$checklist){
        $data_struct[$i]['checklists'][$j] = array(
          'todo'=>$checklist,
          'is_done'=>'0',
          'date_done'=>'',
        );    
      }  
    }   
        
    $procedure->data = CJSON::encode($data_struct); 
    $procedure->completed_steps = 0;
    $procedure->total_steps = $data_struct_tpl->total_steps;
    $procedure->procedure_checklist_tpl_id = $data_struct_tpl->id;
    $procedure->log_case_id = $this->case_id;
    $procedure->save(false); 
  } 
  
            
  
  /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TarLog the static model class
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
		return 'tar_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('resident, requested_dos_date_from, status_id, facility_id, resident_status, admit_date', 'required'),
      array('approved_modified_date','validateApprovedModifiedDate','on'=>'insert, update'),
      array('denied_deferred_date','validateDeniedDeferredDate','on'=>'insert, update'),
      array('applied_date','validateAppliedDate','on'=>'insert, update'),
      array('requested_dos_date_thru','validateDosThru','on'=>'insert, update'),
      array('control_num','validateControlNum','on'=>'insert, update'),
      //array('aging_amount','validateAgingAmount','on'=>'insert, update'),
      //array('requested_dos_date_thru','validateRequestedThru','on'=>'insert, update'),            
      array('reason_for_closing','required','on'=>'close'),
      array('message','required','on'=>'followup'),
      array('send_email_to','email','on'=>'followup'),
      array('send_email_to','validateEmailTo','on'=>'followup'),
			array('is_closed, approved_care_id, status_id, created_by_user_id, facility_id', 'numerical', 'integerOnly'=>true),
			array('aging_amount', 'numerical'),
			array('control_num, resident, medical_num, dx_code, type, resident_status', 'length', 'max'=>45),
      array('control_num, resident, medical_num, dx_code, admit_date, type, requested_dos_date_from, requested_dos_date_thru, applied_date, denied_deferred_date, approved_modified_date, backbill_date, aging_amount, notes, is_closed, reason_for_closing, approved_care_id, status_id, created_by_user_id, facility_id, resident_status, data_struct_checklists, data_struct_alerts, reason_for_closing, message, send_email, send_email_to, condition', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('case_id, control_num, resident, medical_num, dx_code, admit_date, type, requested_dos_date_from, requested_dos_date_thru, applied_date, denied_deferred_date, approved_modified_date, backbill_date, aging_amount, notes, is_closed, reason_for_closing, created_timestamp, approved_care_id, status_id, created_by_user_id, facility_id, resident_status', 'safe', 'on'=>'search'),
		);
	}
  
  public function validateControlNum(){
    if(empty($this->control_num) and $this->status_id == self::$STATUS_UNDER_REVIEW){
      $this->addError('control_num',$this->getAttributeLabel('control_num').' is required.');
    }    
  }
  
  public function validateDosThru(){
    if(!strtotime($this->requested_dos_date_thru) and $this->status_id == self::$STATUS_UNDER_REVIEW){
      $this->addError('requested_dos_date_thru',$this->getAttributeLabel('requested_dos_date_thru').' is required.');
    }    
  }
  
  public function validateAppliedDate(){
    if(!strtotime($this->applied_date) and $this->status_id == self::$STATUS_UNDER_REVIEW){
      $this->addError('applied_date',$this->getAttributeLabel('applied_date').' is required.');
    }    
  }
  
  public function validateWhenApplied0(){
    if($this->status_id == self::$STATUS_UNDER_REVIEW){
      if(empty($this->control_num)){
        $this->addError('control_num',$this->getAttributeLabel('control_num').' is required.');
      }
      if(empty($this->aging_amount)){
        $this->addError('aging_amount',$this->getAttributeLabel('aging_amount').' is required.');
      }
      if(empty($this->control_num)){
        $this->addError('requested_dos_date_thru',$this->getAttributeLabel('requested_dos_date_thru').' is required.');
      }
      if(!strtotime($this->applied_date) and $this->status_id == self::$STATUS_UNDER_REVIEW){
        $this->addError('applied_date',$this->getAttributeLabel('applied_date').' is required.');
      }
    }
  }
  
  public function validateApprovedModifiedDate(){
    if(!strtotime($this->approved_modified_date) and $this->status_id == self::$STATUS_APPROVED){
      $this->addError('approved_modified_date',$this->getAttributeLabel('approved_modified_date').' is required.');
    }
  }
  
  public function validateDeniedDeferredDate(){
    if(!strtotime($this->denied_deferred_date) and ($this->status_id == self::$STATUS_DENIED or $this->status_id == self::$STATUS_DEFERRED)){
      $this->addError('denied_deferred_date',$this->getAttributeLabel('denied_deferred_date').' is required.');
    }
  }
  
  /**
   * Custom validation
   */
  public function validateEmailTo(){
    if($this->send_email=='1' and empty($this->send_email_to)){
      $this->addError('send_email_to','Send Email To is required.');
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
			'tarActivityTrails' => array(self::HAS_MANY, 'TarActivityTrail', 'log_case_id'),
			'alerts' => array(self::HAS_ONE, 'TarAlerts', 'log_case_id'),
			'approvedCare' => array(self::BELONGS_TO, 'TarApprovedCare', 'approved_care_id'),
			'status' => array(self::BELONGS_TO, 'TarStatus', 'status_id'),
			'createdByUser' => array(self::BELONGS_TO, 'TarUser', 'created_by_user_id'),
			'facility' => array(self::BELONGS_TO, 'Facility', 'facility_id'),
			'procedures' => array(self::HAS_ONE, 'TarProcedureChecklist', 'log_case_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'case_id' => 'Case #',
			'control_num' => 'Control Num',
			'resident' => 'Resident',
			'medical_num' => 'Medi-Cal #',
			'dx_code' => 'DX Code',
			'admit_date' => 'Admit Date',
			'type' => 'Type',
			'requested_dos_date_from' => 'Requested DOS From',
			'requested_dos_date_thru' => 'Requested DOS Thru',
			'applied_date' => 'Applied Date',
			'denied_deferred_date' => 'Denied / Deferred Date',
			'approved_modified_date' => 'Approved / Modified Date',
			'backbill_date' => 'Back Bill Date',
			'aging_amount' => 'Aging Amount',
			'notes' => 'Case Notes',
			'is_closed' => 'Is Closed',
			'reason_for_closing' => 'Reason For Closing',
			'created_timestamp' => 'Created Timestamp',
			'approved_care_id' => 'Approved Care',
			'status_id' => 'Status',
			'created_by_user_id' => 'Created By User',
			'facility_id' => 'Facility',
			'resident_status' => 'Resident Status',
      'send_email' => 'Also Send Email',
      'send_email_to' => 'Send A Copy To',
      'message' => 'Please specify the things that you did today.',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function getActiveCases()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('case_id',$this->case_id);
		$criteria->compare('control_num',$this->control_num,true);
		$criteria->compare('resident',$this->resident,true);
    $criteria->compare('status_id',$this->status_id);
		$criteria->compare('requested_dos_date_from',$this->requested_dos_date_from,true);
		$criteria->compare('requested_dos_date_thru',$this->requested_dos_date_thru,true);
		$criteria->compare('is_closed','0');
    $criteria->compare('t.condition',$this->condition,true);

    //filter own facility
    $criteria->addCondition("facility_id in (select facility_id from tar_user_facility where user_id = ".Yii::app()->user->getState('id').")");

    $criteria->order = "requested_dos_date_from asc";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
      //'pagination'=>false,
		));
	}
  
  /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        
        $criteria->with = array('status');

        $criteria->compare('case_id',$this->case_id);
        $criteria->compare('control_num',$this->control_num,true);
        $criteria->compare('resident',$this->resident,true);
        $criteria->compare('medical_num',$this->medical_num,true);
        $criteria->compare('dx_code',$this->dx_code,true);
        $criteria->compare('admit_date',$this->admit_date,true);
        $criteria->compare('type',$this->type,true);
        $criteria->compare('applied_date',$this->applied_date,true);
        $criteria->compare('denied_deferred_date',$this->denied_deferred_date,true);
        $criteria->compare('approved_modified_date',$this->approved_modified_date,true);
        $criteria->compare('backbill_date',$this->backbill_date,true);
        $criteria->compare('aging_amount',$this->aging_amount);
        $criteria->compare('notes',$this->notes,true);
        $criteria->compare('is_closed',$this->is_closed);
        $criteria->compare('reason_for_closing',$this->reason_for_closing,true);
        $criteria->compare('created_timestamp',$this->created_timestamp,true);
        $criteria->compare('approved_care_id',$this->approved_care_id);
        $criteria->compare('status_id',$this->status_id);
        $criteria->compare('created_by_user_id',$this->created_by_user_id);
        $criteria->compare('facility_id',$this->facility_id);
        $criteria->compare('resident_status',$this->resident_status,true);
        $criteria->compare('condition',$this->condition,true);
        
        //requested range
        
        
        if(!empty($this->requested_dos_date_from) and !empty($this->requested_dos_date_thru)){
          $criteria->compare('requested_dos_date_from','>='.date('Y-m-d',strtotime($this->requested_dos_date_from)));
          $criteria->compare('requested_dos_date_thru','<='.date('Y-m-d',strtotime($this->requested_dos_date_thru)));  
        }elseif(!empty($this->requested_dos_date_from) and empty($this->requested_dos_date_thru)){
          $criteria->compare('requested_dos_date_from','>='.date('Y-m-d',strtotime($this->requested_dos_date_from)));
        }elseif(empty($this->requested_dos_date_from) and !empty($this->requested_dos_date_thru)){
          $criteria->compare('requested_dos_date_thru','<='.date('Y-m-d',strtotime($this->requested_dos_date_thru)));
        }else{
        
        }

        //filter own facility
        $criteria->addCondition("facility_id in (select facility_id from tar_user_facility where user_id = ".Yii::app()->user->getState('id').")");

        $criteria->order = "is_closed asc, requested_dos_date_from asc";
        
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
  
  /**** UI Fxns ********/
  public function rowBackgroundColor(){
    if($this->condition == 'Critical'){
      return 'error';
    }elseif($this->condition == 'Warning'){
      return 'warning';
    }else{
      return '';
    }
  }
}