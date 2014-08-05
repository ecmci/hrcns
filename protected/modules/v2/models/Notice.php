<?php

/**
 * This is the model class for table "hr_workflow_change_notice".
 *
 * The followings are the available columns in table 'hr_workflow_change_notice':
 * @property integer $id
 * @property integer $initiated_by
 * @property string $notice_type
 * @property string $notice_sub_type
 * @property string $summary_of_changes
 * @property string $reason
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
 * @property string $attachments
 * @property string $attachment_bom
 * @property string $attachment_fac_adm
 * @property string $attachment_mnl
 * @property string $attachment_corp
 * @property string $effective_date
 * @property string $timestamp
 * @property string $last_updated_timestamp
 *
 * The followings are the available model relations:
 * @property HrEmployeePersonal $personalProfile
 * @property HrUser $processingUser
 * @property HrEmployeeEmployment $employmentProfile
 * @property HrEmployeePayroll $payrollProfile
 * @property ItSystemEmployeeRequest[] $itSystemEmployeeRequests
 */
class Notice extends CActiveRecord
{
	public static $FLAG_DAYS = 2;
	
	public $query, $facility, $employee, $type, $stat, $other_reason, $comments, $decision='0', $edit='0', $effective_from, $effective_to, $licenses;
    public $push = '1';

	/**
	 * Gets the history of notices
	 * @param $emp_id; Employee ID
	 */ 
	public static function getHistory($emp_id=''){
		$c = new CDbCriteria;
		$c->join = "left outer join hr_employee_personal personal on personal.id = t.personal_profile_id";
		$c->compare('personal.emp_id',$emp_id);
		$c->order = 'timestamp desc';
		return new CActiveDataProvider(new Notice, array(
			'criteria'=>$c,
		));
	}
	
	/**
	 * Quick search
	 */
	public function quickSearch(){
		$c = new CDbCriteria;
		$c->compare('id',$this->id,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$c,
		));
	}
	
	/**
	 * Checks if current user can sign
	 */
	public function isSignable(){
        return $this->processing_group == Yii::app()->user->getState('hr_group') and $this->status == 'WAITING';
    }
    
    /**
	 * Route back to BOM
	 */
	public function routeBackToBOM(){
	  $this->decision = '0';

	  $this->decision_corp = '0';	  
	  $this->decision_mnl = '0';
	  $this->decision_fac_adm = '0';
	  $this->decision_bom = '0';
	  
	  $now = date('Y-m-d H:i:s',time());
	  $this->timestamp_corp_signed = $now;	  
	  $this->timestamp_mnl_signed = $now;
	  $this->timestamp_fac_adm_signed = $now;
	  $this->timestamp_bom_signed = $now;
	  
	  $this->processing_group = 'BOM';
      $this->status = 'WAITING';
	  
	  return $this;
  }
    
    /**
	 * Notifies the next group
	 */
	public function notify(){
		$c = new CDbCriteria;
		$c->select = 't.username as username, hu.facility_handled_ids as FACILITY_idFACILITY';
		$c->join = 'left outer join hr_user hu on hu.user_id = t.idUSER';
		switch($this->status){
			case 'NEW': case 'DECLINED': 
			case 'CANCELLED': //BOM only
				$c->compare('hu.group','BOM');
			break;
			case 'WAITING': //next processing group
				$c->compare('hu.group',$this->processing_group);
			break;
			case 'APPROVED': // BOM, MNL
				$c->compare('hu.group',array('BOM','MNL'));
			break;
		} 

		$users = User::model()->findAll($c);
		foreach($users as $user){
			$f = explode(',',$user->FACILITY_idFACILITY);
			if(in_array($this->employment->facility_id,$f)){
				$to = $user->username;
				$subject = Yii::app()->name.' | '.$this->id.' | '.$this->employment->facility->acronym.' | '.$this->notice_type.' | '.$this->employment->position->name.' | '.$this->status;
				$link = Yii::app()->createAbsoluteUrl('hr/workflowchangenotice/view/',array('id'=>$this->id));
				$message = "<p>Hi,</p><p></p><p>Your workflow request has been updated:</p>
				<ul>
				  <li>ID    			: $this->id</li>
				  <li>TYPE  			: $this->notice_type</li>
				  <li>STATUS			: $this->status</li>
				  <li>REVIEWING GROUP 	: $this->processing_group</li>			          
				  <li>LINK  			: <a href='$link'>$link</a></li>
				</ul>        
				";
				Helper::queueMail($to,$subject,$message);
			}
		}
	}
    
     /**
	 * Sets the the signature
	 */
    private function setRoute(){
     if($this->decision == '2'){
            $this->routeBackToBOM();
         }elseif($this->edit == '1' and $this->push == '0'){
            return true; //make this notice stay in the current status and group
         }else{
            $hr_group = Yii::app()->user->getState('hr_group');
            switch($hr_group){
                case 'BOM':
                    $this->decision_bom = '1';
                    $this->processing_group = 'FAC_ADM';
                    $this->status = 'WAITING';        
                break;
                case 'FAC_ADM':
                    $this->decision_fac_adm = $this->decision;
                    $this->processing_group = $this->decision == '1' ? 'MNL' : 'FAC_ADM';
                    $this->status = $this->decision == '0' ? 'DECLINED' : 'WAITING';
                break;
                case 'MNL':
                    $this->decision_mnl = $this->decision;
                    $this->processing_group = $this->decision == '1' ? 'CORP' : 'MNL';
                    $this->status = $this->decision == '0' ? 'DECLINED' : 'WAITING';
                    $this->status = $this->scenario == 'prepare' ? 'WAITING' : $this->status;        
                break;
                case 'CORP':                    
					if($this->edit == '1') return;
					$this->decision_corp = $this->decision;					
                    $this->processing_group = 'CORP';
                    $this->status = $this->decision == '1' ? 'APPROVED' : 'DECLINED';
                break;
            }
         }           
    }
    
    
    private function setRoute0(){
        if($this->decision == '2'){
            $this->routeBackToBOM();
        }elseif($this->edit == '1'){
            return true; //make this notice stay in the current status and group
        }else{
            $hr_group = Yii::app()->user->getState('hr_group');
            switch($hr_group){
                case 'BOM':
                    $this->decision_bom = '1';
                    $this->processing_group = 'FAC_ADM';
                    $this->status = 'WAITING';        
                break;
                case 'FAC_ADM':
                    $this->decision_fac_adm = $this->decision;
                    $this->processing_group = $this->decision == '1' ? 'MNL' : 'FAC_ADM';
                    $this->status = $this->decision == '0' ? 'DECLINED' : 'WAITING';
                break;
                case 'MNL':
                    $this->decision_mnl = $this->decision;
                    $this->processing_group = $this->decision == '1' ? 'CORP' : 'MNL';
                    $this->status = $this->decision == '0' ? 'DECLINED' : 'WAITING';
                    $this->status = $this->scenario == 'prepare' ? 'WAITING' : $this->status;        
                break;
                case 'CORP':
                    $this->decision_corp = $this->decision;
                    $this->processing_group = 'CORP';
                    $this->status = $this->decision == '1' ? 'APPROVED' : 'DECLINED';
                break;
            }
        }
        
    }
    
    /**
	 * Sets the the signature
	 */
    private function setSignee(){
        $hr_group = Yii::app()->user->getState('hr_group');
        $user_id = Yii::app()->user->getState('id');
        $now = date('Y-m-d H:i:s',time());
        $comments = $this->comments;
        switch($hr_group){
            case 'BOM':
                $this->bom_id = $user_id;
                $this->comment_bom = $this->comments;
                $this->timestamp_bom_signed = $now;
            break;
            case 'FAC_ADM' : 
				$this->fac_adm_id = $user_id;
				$this->comment_fac_adm = $this->comments;
				$this->timestamp_fac_adm_signed = $now;
			break;
			case 'MNL' : 
				$this->mnl_id = $user_id;
				$this->comment_mnl = $this->comments;
				$this->timestamp_mnl_signed = $now;
			break;
			case 'CORP' : 
				$this->corp_id = $user_id;
				$this->comment_corp = $this->comments;
				$this->timestamp_corp_signed = $now;				
			break;
        }
    }
    
    
	
	/**
	 * Sets the the signature and routes this to the appropriate processing group
	 */
    public function routeWorkflow(){
        $this->setSignee();
        $this->setRoute();
    }
	
	/**
	 * Returns true if it's flagged from days created
	 */
	public function needsAttention(){
		$diff = time() - strtotime($this->timestamp);
		$days_ago = floor($diff / (60 * 60 * 24));
		return $days_ago > self::$FLAG_DAYS;
	}
	
	/**
	 * Returns received from last processing group
	 */
	public function getReceived(){
		$d = '';
		$base_timestamp = 0;
		switch($this->processing_group){
			case 'BOM': $base_timestamp = $this->timestamp; break;
			case 'FAC_ADM': $base_timestamp = $this->timestamp_bom_signed;  break;
			case 'MNL': $base_timestamp = $this->timestamp_fac_adm_signed;  break;
			case 'CORP': $base_timestamp = $this->timestamp_mnl_signed;  break;
		}
		$base_timestamp = abs(time() - strtotime($base_timestamp));
		if($base_timestamp >= 86400){ //days
			$d = floor($base_timestamp / 86400).' day(s) ago';
		}elseif($base_timestamp >= 3600){
			$d = floor($base_timestamp / 3600).' hour(s) ago';  
		}elseif($base_timestamp >= 60){
			$d = floor($base_timestamp / 60).' minute(s) ago';  
		}else{
			$d = $base_timestamp.' seconds ago';  
		}
		return $d;
	}
    

	/**
	 * Returns processing group in human form
	 */
	 public function getProcessingGroup(){
		 switch($this->processing_group){
			 case 'BOM': return 'BOM'; break;
			 case 'FAC_ADM': return 'Facility Admin'; break;
			 case 'MNL': return 'AR Manila'; break;
			 case 'CORP': return 'HR'; break;
		 }
	 }
	
	/**
	 * Returns status in human form
	 */
	 public function getStatus(){
		 return ($this->status == 'WAITING') ? App::printEnum($this->status).' on '.$this->getProcessingGroup() : $this->status;
	 }

	/**
	 * Returns type in human form
	 */ 
	 public function getType(){
		 $t = $this->notice_type;
		 $t = (!empty($this->notice_sub_type)) ? $t.' - '.$this->notice_sub_type : $t;
		 //$t .= $this->notice_sub_type;
		 return $t; 
	 } 
   
   /**
    * Encodes attachment for storage
    */       
   private function encodeAttachments(){
      $this->attachments = serialize($this->attachments);
   }
   
   /**
    * Decodes attachment for display
    */       
   private function decodeAttachments(){
      $this->attachments = !empty($this->attachments) ? unserialize($this->attachments) : array();
   }

	/**
	 * Override: beforeValidate()
	 * @param
	 * @return parent method
	 */
	 public function beforeValidate(){
		 $this->initiated_by = Yii::app()->user->getState('id');
		 return parent::beforeValidate();
	 }
	 
	/**
	 * Saves the licenses
	 */  
	private function encodeLicenses(){
		if(empty($this->licenses)) return true;
		foreach($this->licenses as $l){
			$lic = new Document;
			$lic->attributes = $l;
			$lic->emp_id = $this->profile_id;
			$lic->submitted_by = Yii::app()->user->getState('id');
			$lic->save(false);
		}
	}
	
	
	/**
	 * Override parent afterSave()
	 */
	protected function afterSave()
	{
		$this->notify();
		return parent::afterSave();
	}
	
	/**
	 * Override: beforeSave()
	 * @param
	 * @return parent method
	 */
	 public function beforeSave(){
		$this->encodeAttachments();
		$this->encodeLicenses();
		$this->routeWorkflow();		
		if($this->isNewRecord) { 
			$this->timestamp = date('Y-m-d H:i:s',time()); 
			$this->status = 'WAITING';
		}
		$this->last_updated_timestamp = date('Y-m-d H:i:s',time()); 
		return parent::beforeSave();
	 }
   
	/**
	 * Override: After find actions
	 * @param
	 * @return parent method
	 */
	 protected function afterFind(){
		 $this->employee = $this->employment->employee->getFullName();
		 $this->type = $this->getType();
		 $this->facility = $this->employment->facility->acronym;
		 $this->decodeAttachments();
		 return parent::afterFind();
	 }
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Notice the static model class
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
			//prepare scenario
			array('notice_sub_type','validateSubType','on'=>'prepare'),
			array('reason','validateReason','on'=>'prepare'),
            array('attachments','required','on'=>'prepare'),
			
			array('notice_type, effective_date, initiated_by', 'required'),
			array('initiated_by, processing_user, profile_id, personal_profile_id, employment_profile_id, payroll_profile_id, bom_id, fac_adm_id, mnl_id, corp_id, decision_bom, decision_fac_adm, decision_mnl, decision_corp', 'numerical', 'integerOnly'=>true),
			array('notice_type, status', 'length', 'max'=>10),
			array('notice_sub_type', 'length', 'max'=>20),
			array('reason', 'length', 'max'=>256),
			array('processing_group', 'length', 'max'=>7),
			array('attachment_bom, attachment_fac_adm, attachment_mnl, attachment_corp', 'length', 'max'=>128),
			array('push, licenses, decision, comments, other_reason, summary_of_changes, timestamp_bom_signed, timestamp_fac_adm_signed, timestamp_mnl_signed, timestamp_corp_signed, comment_bom, comment_fac_adm, comment_mnl, comment_corp, attachments, effective_date, timestamp, last_updated_timestamp', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('effective_from, effective_to, type, facility, employee, id, initiated_by, notice_type, notice_sub_type, summary_of_changes, reason, status, processing_group, processing_user, profile_id, personal_profile_id, employment_profile_id, payroll_profile_id, bom_id, fac_adm_id, mnl_id, corp_id, timestamp_bom_signed, timestamp_fac_adm_signed, timestamp_mnl_signed, timestamp_corp_signed, decision_bom, decision_fac_adm, decision_mnl, decision_corp, comment_bom, comment_fac_adm, comment_mnl, comment_corp, attachments, attachment_bom, attachment_fac_adm, attachment_mnl, attachment_corp, effective_date, timestamp, last_updated_timestamp', 'safe', 'on'=>'search'),
		);
	}
	
	/** My validators **/
	public function validateReason(){
		if($this->notice_type == 'CHANGE' and $this->reason == 'Other' and empty($this->other_reason)){
			$this->addError('other_reason','Other Reason is required.');
		}
	}
	
	public function validateSubType(){
		if($this->notice_type == 'CHANGE' and empty($this->notice_sub_type)){
			$this->addError('notice_sub_type','Notice Sub Type is required.');
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
			'personal' => array(self::BELONGS_TO, 'Personal', 'personal_profile_id'),
			'processingUser' => array(self::BELONGS_TO, 'User', 'processing_user'),
			'employment' => array(self::BELONGS_TO, 'Employment', 'employment_profile_id'),
			'payroll' => array(self::BELONGS_TO, 'Payroll', 'payroll_profile_id'),
			'bom' => array(self::BELONGS_TO, 'User', 'bom_id'),
			'facadm' => array(self::BELONGS_TO, 'User', 'fac_adm_id'),
			'mnl' => array(self::BELONGS_TO, 'User', 'mnl_id'),
			'corp' => array(self::BELONGS_TO, 'User', 'corp_id'),
			'itSystemEmployeeRequests' => array(self::HAS_MANY, 'ItSystemEmployeeRequest', 'hr_workflow_notice_id'),
			'initBy'=> array(self::BELONGS_TO, 'User', 'initiated_by'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Notice ID',
			'initiated_by' => 'Initiated By',
			'notice_type' => 'Notice Type',
			'notice_sub_type' => 'Notice Sub Type',
			'summary_of_changes' => 'Summary Of Changes',
			'reason' => 'Reason',
			'status' => 'Status',
			'processing_group' => 'Processing Group',
			'processing_user' => 'Processing User',
			'profile_id' => 'Profile',
			'personal_profile_id' => 'Personal Profile',
			'employment_profile_id' => 'Employment Profile',
			'payroll_profile_id' => 'Payroll Profile',
			'bom_id' => 'Bom',
			'fac_adm_id' => 'Fac Adm',
			'mnl_id' => 'Mnl',
			'corp_id' => 'Corp',
			'timestamp_bom_signed' => 'Timestamp Bom Signed',
			'timestamp_fac_adm_signed' => 'Timestamp Fac Adm Signed',
			'timestamp_mnl_signed' => 'Timestamp Mnl Signed',
			'timestamp_corp_signed' => 'Timestamp Corp Signed',
			'decision_bom' => 'Decision Bom',
			'decision_fac_adm' => 'Decision Fac Adm',
			'decision_mnl' => 'Decision Mnl',
			'decision_corp' => 'Decision Corp',
			'comment_bom' => 'Comment Bom',
			'comment_fac_adm' => 'Comment Fac Adm',
			'comment_mnl' => 'Comment Mnl',
			'comment_corp' => 'Comment Corp',
			'attachments' => 'Attachments',
			'attachment_bom' => 'Attachment Bom',
			'attachment_fac_adm' => 'Attachment Fac Adm',
			'attachment_mnl' => 'Attachment Mnl',
			'attachment_corp' => 'Attachment Corp',
			'effective_date' => 'Effective Date',
			'timestamp' => 'Timestamp',
			'last_updated_timestamp' => 'Last Updated Timestamp',
		);
	}

	/**
	 * Retrieves all those active for the facility
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function getActive()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = 'employment';
		
		//show only those active
		$criteria->addInCondition('t.status',array('WAITING'));
		
		//filter according to assigned facility
		$criteria->addInCondition('employment.facility_id',Yii::app()->user->getState('hr_facility_handled_ids'));
	
		//not routed to user's current group
		$criteria->addNotInCondition('t.processing_group',array(Yii::app()->user->getState('hr_group')));
	
		//order
		$criteria->order = 't.status asc, t.notice_type desc, t.timestamp asc';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>100,
			),
		));
	}
	
	/**
	 * Retrieves all those routed for the group
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function getRouted(){
		$criteria=new CDbCriteria;
		$criteria->with = 'employment';
		
		//show only those active last 30 days
		$criteria->addInCondition('t.status',array('WAITING','NEW'));
		
		//show only those routed to current user group
		$criteria->compare('t.processing_group',Yii::app()->user->getState('hr_group'));
		
        //filter according to assigned facility
		$criteria->addInCondition('employment.facility_id',Yii::app()->user->getState('hr_facility_handled_ids'));

        
		//order
		$criteria->order = 't.status asc, t.notice_type desc, t.timestamp asc';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>100,
			),
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
        
        $criteria->with = array('employment');

        $criteria->compare('t.id',$this->id);
        $criteria->compare('t.initiated_by',$this->initiated_by);
        $criteria->compare('t.notice_type',$this->notice_type,true);
        $criteria->compare('t.notice_sub_type',$this->notice_sub_type,true);
        $criteria->compare('t.reason',$this->reason,true);
        $criteria->compare('t.status',$this->status,true);
        $criteria->compare('t.processing_group',$this->processing_group,true);
        
        $criteria->compare('employment.facility_id',$this->facility,true);
        $criteria->compare('employment.emp_id',$this->employee);
        
        if(!empty($this->effective_from) and !empty($this->effective_to)){
			$criteria->addBetweenCondition('effective_date', $this->effective_from, $this->effective_to);
		}elseif(!empty($this->effective_from) and empty($this->effective_to)){
			$criteria->addCondition('effective_date >= '.$this->effective_from);
		}elseif(empty($this->effective_from) and !empty($this->effective_to)){
			$criteria->addCondition('effective_date <= '.$this->effective_to);
		}else{}
		
		//FILTER: show only those belonging to user's facility
		$criteria->compare('employment.facility_id',Yii::app()->user->getState('hr_facility_handled_ids'));

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}
