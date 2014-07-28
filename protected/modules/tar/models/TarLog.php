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
  private $DB_DATE_FORMAT = 'Y-m-d';
  private $HUMAN_DATE_FORMAT = 'm/d/Y';
  public static $STATUS_APPROVED = '5';
  
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
    $requested = new DateTime(date('Y-m-d',strtotime($this->requested_dos_date_from)));
    $today = new DateTime(date('Y-m-d',time()));
    $interval = $requested->diff($today);
    $this->age_in_days = $interval->days;

    return parent::afterFind();
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
    }elseif($this->scenario == 'update'){
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
    * Send follow up
    */       
  public function followUp(){
    $message = new TarMessaging;
    $message->from_user_id = Yii::app()->user->getState('id');
    $message->to_user_id = $this->created_by_user_id;
    $message->message = $this->message;
    $message->save(false);
    
    if($this->send_email == '1'){
      Helper::queueMail($this->send_email_to,'TAR Follow Up | Case #'.$this->case_id,$this->message);
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
    $ds_tpl = TarAlertsTemplate::model()->find("name='Default'");
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
    $data_struct_tpl = TarProcedureTemplate::model()->find("name='Default'");
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
			array('resident, requested_dos_date_from, status_id, facility_id', 'required','on'=>'insert'),
      array('reason_for_closing','required','on'=>'close'),
      array('message','required','on'=>'followup'),
      array('send_email_to','email','on'=>'followup'),
      array('send_email_to','validateEmailTo','on'=>'followup'),
			array('is_closed, approved_care_id, status_id, created_by_user_id, facility_id', 'numerical', 'integerOnly'=>true),
			array('aging_amount', 'numerical'),
			array('control_num, resident, medical_num, dx_code, type, reason_for_closing, resident_status', 'length', 'max'=>45),
      array('control_num, resident, medical_num, dx_code, admit_date, type, requested_dos_date_from, requested_dos_date_thru, applied_date, denied_deferred_date, approved_modified_date, backbill_date, aging_amount, notes, is_closed, reason_for_closing, approved_care_id, status_id, created_by_user_id, facility_id, resident_status, data_struct_checklists, data_struct_alerts, reason_for_closing, message, send_email, send_email_to', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('case_id, control_num, resident, medical_num, dx_code, admit_date, type, requested_dos_date_from, requested_dos_date_thru, applied_date, denied_deferred_date, approved_modified_date, backbill_date, aging_amount, notes, is_closed, reason_for_closing, created_timestamp, approved_care_id, status_id, created_by_user_id, facility_id, resident_status', 'safe', 'on'=>'search'),
		);
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
		$criteria->compare('requested_dos_date_from',$this->requested_dos_date_from,true);
		$criteria->compare('requested_dos_date_thru',$this->requested_dos_date_thru,true);
		$criteria->compare('is_closed','0');
    

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
      //'pagination'=>false,
		));
	}
}